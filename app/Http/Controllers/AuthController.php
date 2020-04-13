<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Exception;
use DateTimeImmutable;
use Covid\Users\Domain\UsersQuery;
use Covid\Users\Domain\UserRepository;
use Covid\Users\Domain\UserId;
use Covid\Users\Domain\PhoneNumber;
use Covid\Users\Domain\PasswordHelper;
use Covid\Users\Domain\Password;
use Covid\Users\Domain\Name;
use Covid\Users\Domain\Exceptions\EmailOrPhoneIsRequired;
use Covid\Users\Domain\Email;
use Covid\Users\Application\Commands\RegisterUser;
use Covid\Shared\CommandBus;
use Covid\Shared\BaseException;

class AuthController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getLoginOrRegister(Request $request)
    {
        if ($request->session()->get('userId')) {
            return redirect()->route('profile');
        }

        return view('auth.loginOrRegister');
    }

    public function getLogout(Request $request)
    {
        $request->session()->flush();
        $request->session()->save();
        
        return redirect()->route('login');
    }

    public function postLoginOrRegister(
        Request $request,
        UsersQuery $query,
        UserRepository $repo,
        PasswordHelper $passwordHelper,
        CommandBus $commandBus
    ) {
        if ($request->get('action') === 'login') {
            return $this->postLogin($request, $query, $repo, $passwordHelper);
        } else {
            return $this->postRegister($request, $commandBus);
        }
    }

    public function postLogin(
        Request $request,
        UsersQuery $query,
        UserRepository $repo,
        PasswordHelper $passwordHelper
    ) {

        $emailOrPhone = $request->get('emailOrPhone');
        
        if ($request->get('emailOrPhone')) {
            $phone = null;
            $email = null;

            try {

                if (strstr($emailOrPhone, '@')) {
                    $email = new Email($emailOrPhone);

                } elseif (strstr($emailOrPhone, '7')) {
                    $phone = new PhoneNumber($emailOrPhone);

                } else {
                    throw new EmailOrPhoneIsRequired();
                }

                $password = new Password($request->get('password'));

                $user = $query->findByEmailOrPhoneNumber(
                    $email,
                    $phone,
                );

                $user = $repo->find(new UserId($user['id']));
                
                if ($user->checkPassword($password, $passwordHelper)) {
                    $request->session()->put('userId', $user->getAggregateRootId());
                    $request->session()->save();
                    
                    return redirect()->route('profile');
                } else {
                    $error = 'Sorry, your password was incorrect';
                }

            } catch(BaseException $e) {
                $error = $e->getName();

            } catch(Exception $e) {
                $error = $e->getMessage();
            }
        }

        return view('auth.loginOrRegister', [
            'loginError' => $error,
            'emailOrPhone' => $emailOrPhone
        ]);
    }

    public function postRegister(Request $request, CommandBus $commandBus)
    {
        $error = null;
        
        try {
            $userId = UserId::new();

            $command = new RegisterUser(
                $userId,
                new Name($request->get('name') ?: ''),
                $request->get('email') ? new Email($request->get('email')) : null,
                $request->get('phone') ? new PhoneNumber($request->get('phone')) : null,
                new Password($request->get('password') ?: ''),
                new DateTimeImmutable()
            );

            $commandBus->dispatch($command);

            $request->session()->put('userId', (string)$userId);
            $request->session()->save();
            
            return redirect()->route('profile');

        } catch(BaseException $e) {
            $error = $e->getName();

        } catch(Exception $e) {
            $error = $e->getMessage();
        }
        
        return view('auth.loginOrRegister', [
            'registerError' => $error,
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
        ]);
    }
}
