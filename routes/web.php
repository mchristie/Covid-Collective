<?php

use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Covid\Users\Domain\UsersQuery;
use Covid\Users\Domain\UserRepository;
use Covid\Users\Domain\UserId;
use Covid\Users\Domain\PhoneNumber;
use Covid\Users\Domain\PasswordHelper;
use Covid\Users\Domain\Password;
use Covid\Users\Domain\Exceptions\EmailOrPhoneIsRequired;
use Covid\Users\Domain\Email;
use Covid\Shared\CommandBus;
use Covid\Shared\BaseException;
use Covid\Resources\Domain\Url;
use Covid\Resources\Domain\Title;
use Covid\Resources\Domain\ResourceId;
use Covid\Resources\Domain\Media;
use Covid\Resources\Domain\Description;
use Covid\Resources\Domain\Cost;
use Covid\Resources\Domain\Category;
use Covid\Resources\Domain\Audience;
use Covid\Resources\Application\Query\ResourcesQuery;
use Covid\Resources\Application\Commands\CreateResource;
use Covid\Groups\Application\Groups;
use App\Mail\VolunteerSignedUp;

Route::get('/', function (Request $request) {
    // return view('soon');
    return view('home');
})->name('home')->middleware('cache.headers:public;max_age=3600');

/*
 *  Resources
 */

Route::get('/resources', function (Request $request, ResourcesQuery $resources) {
    return view('resources', [
        'resources' => $resources->getResources($request->all()),
        'selected' => $request->all()
    ]);
})->name('resources')->middleware('cache.headers:public;max_age=300');

Route::post('/resources/add', function (Request $request, CommandBus $bus, ResourcesQuery $resources) {
    $validator = Validator::make($request->all(), [
        'title' => 'required',
        'description' => 'required',
        'url' => 'required',
        'audience' => 'required',
        'category' => 'required',
        'cost' => 'required',
        'media' => 'required',
    ]);

    // Check for existing resource
    $existing = $resources->getResources(['url' => $request->get('url')]);
    if (count($existing)) {
        $data['error'] = 'Looks like this resource already exists!';
        return view('addResource', $data);
    }
    
    $data = $request->all();
    if ($validator->fails()) {
        $data['error'] = implode('<br>', $validator->errors()->all());
        
    } else {

        try {

            $command = new CreateResource(
                ResourceId::new(),
                new Title($request->get('title')),
                new Description($request->get('description')),
                new Url($request->get('url')),
                new Audience($request->get('audience')),
                new Category($request->get('category')),
                new Cost($request->get('cost')),
                new Media($request->get('media')),
                new DateTimeImmutable()
            );
            
            $bus->dispatch($command);
            $data = [
                'success' => 'Resource saved'
            ];
            
        } catch (\Throwable $e) {
            $data = $request->all();
            $data['error'] = $e->getMessage();
        }
    }
    
    return view('addResource', $data);
})->name('addResource');

Route::get('/resources/add', function (Request $request) {
    return view('addResource', $request->all());
})->name('addResource')->middleware('cache.headers:public;max_age=3600');

/*
 *  Groups
 */

Route::get('/groups', function (Request $request, Groups $groups) {
    return view('groups', [
        'groups' => $groups->getGroups()
    ]);
})->name('groups')->middleware('cache.headers:public;max_age=3600');

/*
 *  Volunteer
 */

Route::get('/volunteer', function (Request $request) {
    return view('volunteer', [
        'thanks' => $request->get('thanks')
    ]);
})->name('volunteer')->middleware('cache.headers:public;max_age=3600');


Route::post('/volunteer', function (Request $request) {
    DB::table('interests')->insert([
        'id' => (string) Uuid::uuid4(),
        'email' => $request->get('email'),
        'created_at' => date('Y-m-d H:i:s')
    ]);
    
    Mail::to($request->get('email'))
        ->send(new VolunteerSignedUp($request->get('email')));

    return redirect()->route('volunteer', ['thanks' => 1]);
});

/*
 *  Other
 */

Route::get('/ways-to-help', function (Request $request) {
    return view('help');
})->name('help')->middleware('cache.headers:public;max_age=3600');

/*
 * Users
 */

Route::any('login', function(Request $request, UsersQuery $query, UserRepository $repo, PasswordHelper $passwordHelper) {

    $error = null;
    $emailOrPhone = $request->get('emailOrPhone');

    if ($request->getMethod() === 'POST' && $request->get('password')) {
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

    return view('login', [
        'error' => $error,
        'emailOrPhone' => $emailOrPhone
    ]);
})->name('login')->middleware('cache.headers:public;max_age=3600');

Route::get('profile', function(Request $request, UsersQuery $query) {
    if (!$request->session()->get('userId')) {
        return redirect()->route('login');
    };
    
    $user = $query->find(new UserId($request->session()->get('userId')));
    
    return view('profile', [
        'user' => $user
    ]);
})->name('profile');

/*
 *  SEO
 */

Route::get('/robots.txt', function (Request $request) {
    return response("User-agent: *\nAllow: /\n\nSitemap: ".route('sitemap'), 200, [
        'Content-Type' => 'text/plain'
    ]);
})->name('robots')->middleware('cache.headers:public;max_age=3600');

Route::get('/sitemap.xml', function (Request $request) {
    return response(view('sitemap')->render(), 200, [
        'Content-Type' => 'text/xml'
    ]);
})->name('sitemap')->middleware('cache.headers:public;max_age=3600');
