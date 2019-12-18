<!--tutoriel OAuth : https://www.youtube.com/watch?v=I5tFlK5PPjc -->
<!-- page qui gere la demande de connexion et l'utilisation des token entre l'api distante et le sit local-->

<?php
require __DIR__.'\vendor\autoload.php';
require 'config.php';
//require 'secret.php'; //ligne ajoutée par rapport au tutoriel sinon le code genere une page blanche ou un code d'erreur


use GuzzleHttp\Client;

$client = new Client([
    // You can set any number of default request options.
    'timeout'  => 2.0,
    //verification du certificat (téléchargé préalablement sur curl.haxx.se) certificat concernant curl
    'verify'=>__DIR__.'/cacert.pem'
]);

try
{
$response =$client->request('GET','https://accounts.google.com/.well-known/openid-configuration');
$discoveryJSON = json_decode((string)$response->getBody());
$tokenEndpoint = $discoveryJSON->token_endpoint;
$userInfoEndpt = $discoveryJSON->userinfo_endpoint;

//recuperation du token d'ouverture de session
$currentFolder = "http://localhost/OAuth2_TEST/";//a deplacer en variable d'environnement
$URI =$currentFolder.'connect.php';

$response = $client->request('POST',$tokenEndpoint,
[
    'form_params' =>
    [ 
        'code'=>$_GET['code'],
        'client_id'=> GOOGLE_ID,
        'client_secret' =>GOOGLE_SECRET,
        'redirect_uri' => $URI,
        'grant_type' => 'authorization_code'
    ]
]);

$accessToken = json_decode($response->getBody())->access_token; 

//envoie du token d'ouverture de session
$response = $client->request('GET', $userInfoEndpt,
[
    'headers' =>
    [
        'Authorization' =>'Bearer' . $accessToken
    ]
]);
$response = json_decode($response->getBody());

if($response->email_verified === true)
{
    //-----partie a virer si je veut que le connect n'est pas de warning php-----//
    session_start();
    $_SESSION['email'] = $response->email;
    header('Location: http://localhost/OAuth2_TEST/secret.php');
    exit();
    //---------------------------------------------------------------------------//

}

} catch(\GuzzleHttp\Exception\ClientException $exception)
{
    dump($exception->getMessage());
}






?>