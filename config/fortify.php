<?php

use Laravel\Fortify\Features;

return [

    /*
    |--------------------------------------------------------------------------
    | Fortify Guard (Mecanismo de autenticação)
    |--------------------------------------------------------------------------
    | en:
    | Here you may specify which authentication guard Fortify will use while
    | authenticating users. This value should correspond with one of your
    | guards that is already present in your "auth" configuration file.
    |
    | pt-br:
    | Aqui você pode especificar qual guard de autenticação o Fortify usará ao
    | autenticar usuários. Este valor deve corresponder com um dos seus
    | guards que já existe na sua configuração de "auth".  
    |
    */

    'guard' => 'web',

    /*
    |--------------------------------------------------------------------------
    | Fortify Password Broker (Corretor de Senhas)
    |--------------------------------------------------------------------------
    | en:
    | Here you may specify which password broker Fortify can use when a user
    | is resetting their password. This configured value should match one
    | of your password brokers setup in your "auth" configuration file.
    |
    | pt-br:
    | Aqui você pode especificar qual corretor de senhas o Fortify pode usar quando um usuário
    | estiver redefinindo sua senha. Este valor configurado deve corresponder a um dos
    | corretores de senhas definidos no seu arquivo de configuração "auth".
    */

    'passwords' => 'users',

    /*
    |--------------------------------------------------------------------------
    | Username / Email (nome de usuário / e-mail)
    |--------------------------------------------------------------------------
    | en:
    | This value defines which model attribute should be considered as your
    | application's "username" field. Typically, this might be the email
    | address of the users but you are free to change this value here.
    |
    | Out of the box, Fortify expects forgot password and reset password
    | requests to have a field named 'email'. If the application uses
    | another name for the field you may define it below as needed.
    |
    | pt-br:
    | Este valor define qual atributo do modelo deve ser considerado como o campo
    | "nome de usuário" da sua aplicação. Normalmente, isso pode ser o endereço de
    | e-mail dos usuários, mas você pode alterar esse valor aqui, se desejar.
    |
    | Por padrão, o Fortify espera que os pedidos de "esqueci minha senha" e "redefinir senha"
    | tenham um campo chamado 'email'. Se a aplicação usar outro nome para esse campo,
    | você pode defini-lo abaixo conforme necessário.
    */

    'username' => 'email',

    'email' => 'email',

    /*
    |--------------------------------------------------------------------------
    | Lowercase Usernames (nome de usuário em minúsculas)
    |--------------------------------------------------------------------------
    | en:
    | This value defines whether usernames should be lowercased before saving
    | them in the database, as some database system string fields are case
    | sensitive. You may disable this for your application if necessary.
    |
    | pt-br:
    | Este valor define se os nomes de usuário devem ser convertidos para letras minúsculas 
    | antes de serem salvos no banco de dados, já que alguns campos de texto em sistemas de 
    | banco de dados diferenciam maiúsculas de minúsculas.
    | Você pode desativar essa opção para sua aplicação, se necessário.
    */

    'lowercase_usernames' => true,

    /*
    |--------------------------------------------------------------------------
    | Home Path (caminho da home)
    |--------------------------------------------------------------------------
    | en:
    | Here you may configure the path where users will get redirected during
    | authentication or password reset when the operations are successful
    | and the user is authenticated. You are free to change this value.
    |
    | pt-br:
    | Aqui você pode configurar o caminho para o qual os usuários serão redirecionados durante
    | a autenticação ou redefinição de senha, quando as operações forem bem-sucedidas
    | e o usuário estiver autenticado. Você pode alterar esse valor livremente.
    */

    'home' => '/',

    /*
    |--------------------------------------------------------------------------
    | Fortify Routes Prefix / Subdomain (roteamento de prefixo / subdomínio)
    |--------------------------------------------------------------------------
    | en:
    | Here you may specify which prefix Fortify will assign to all the routes
    | that it registers with the application. If necessary, you may change
    | subdomain under which all of the Fortify routes will be available.
    |
    | pt-br:
    | Aqui você pode especificar qual prefixo o Fortify irá atribuir a todas as rotas
    | que ele registrar na aplicação. Se necessário, você também pode alterar o subdomínio
    | sob o qual todas as rotas do Fortify estarão disponíveis.
    
    */

    'prefix' => '',

    'domain' => null,

    /*
    |--------------------------------------------------------------------------
    | Fortify Routes Middleware (roteamento de middleware [intermediario])
    |--------------------------------------------------------------------------
    | en:
    | Here you may specify which middleware Fortify will assign to the routes
    | that it registers with the application. If necessary, you may change
    | these middleware but typically this provided default is preferred.
    |
    | pt-br:
    | Aqui você pode especificar quais middlewares o Fortify irá atribuir às rotas
    | que ele registra na aplicação. Se necessário, você pode alterar esses middlewares,
    | mas normalmente o valor padrão fornecido é o mais recomendado.
    */

    'middleware' => ['web'],

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting (limite de taxa)
    |--------------------------------------------------------------------------
    | en:
    | By default, Fortify will throttle logins to five requests per minute for
    | every email and IP address combination. However, if you would like to
    | specify a custom rate limiter to call then you may specify it here.
    |
    | pt-br:
    | Por padrão, o Fortify limitará as tentativas de login a cinco requisições por minuto
    | para cada combinação de e-mail e endereço IP. No entanto, se você quiser especificar
    | um limitador de taxa personalizado para ser utilizado, você pode defini-lo aqui.
    */

    'limiters' => [
        'login' => 'login',
        'two-factor' => 'two-factor',
    ],

    /*
    |--------------------------------------------------------------------------
    | Register View Routes (roteamento de visualização de registro)
    |--------------------------------------------------------------------------
    | en:
    | Here you may specify if the routes returning views should be disabled as
    | you may not need them when building your own application. This may be
    | especially true if you're writing a custom single-page application.
    |
    | pt-br:
    | Aqui você pode especificar se as rotas que retornam visualizações devem ser desabilitadas,
    | pois você pode não precisar delas ao construir sua própria aplicação. Isso pode ser
    | especialmente válido se você estiver criando uma aplicação de página única personalizada.
    */

    'views' => true,

    /*
    |--------------------------------------------------------------------------
    | Features (características)
    |--------------------------------------------------------------------------
    | en:
    | Some of the Fortify features are optional. You may disable the features
    | by removing them from this array. You're free to only remove some of
    | these features or you can even remove all of these if you need to.
    |
    | pt-br:
    | Aqui você pode especificar se as rotas que retornam visualizações devem
    | ser desabilitadas, pois você pode não precisar delas ao construir sua 
    | própria aplicação. Isso pode ser especialmente válido se você estiver
    | criando uma aplicação de página única personalizada.
    */

    'features' => [
        Features::registration(),
        Features::resetPasswords(),
//        Features::emailVerification(),
//        Features::updateProfileInformation(),
//        Features::updatePasswords(),
//        Features::twoFactorAuthentication([
//            'confirm' => true,
//            'confirmPassword' => true,
            // 'window' => 0,
//        ]),
    ],

];
