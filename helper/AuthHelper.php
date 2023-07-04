<?php

require_once './model/UsuariosModel.php';

class AuthHelper{
    private $secretKey;
    private $usuario;
    private $usuarioModel;

    public function __construct() {
        $this->usuarioModel = new UsuariosModel();
        $this->usuario = null;
        $this->secretKey = 'm4Te0K3y';
    }

    public function validarPermisos() {
        $header = apache_request_headers();
        if(!isset($header['Authorization'])) {
            return null;
        }
        $authorization = $header['Authorization'];
        $params = explode(' ', $authorization);
        $token = $params[1];
        $idUsuario = $this->comprobarToken($token);
        if($idUsuario) {
            $this->usuario = $this->usuarioModel->getByEmail($idUsuario);
            return true;
        } else {
            return null;
        }
    }

    public function getToken($usuario) {
        $userData = [
            'id' => $usuario->id_usuario,
            'email' => $usuario->email
        ];
        $tokenData = [
            'sub' => $usuario->id_usuario,
            'iat' => time(),
            'exp' => time() + (60*60*3),
            'data' => $userData
        ];
        // Genera el token JWT
        $header = json_encode(['alg' => 'HS256', 'typ' => 'JWT']);
        $header = base64_encode($header);

        $payload = json_encode($tokenData);
        $payload = base64_encode($payload);

        $signature = hash_hmac('sha256', "$header.$payload", $this->secretKey, true);
        $signature = base64_encode($signature);

        $token = "$header.$payload.$signature";
        return ['token' => $token];
    }

    private function comprobarToken($token) {
         // Divide el token en sus componentes: encabezado, payload y firma
         [$header, $payload, $signature] = explode('.', $token);

         // Decodifica el encabezado y el payload
         $headerData = json_decode(base64_decode($header), true);
         $payloadData = json_decode(base64_decode($payload), true);
 
         // Verifica la firma del token
         $hash = hash_hmac('sha256', "$header.$payload", $this->secretKey, true);
         $signatureData = base64_decode($signature);
         $isSignatureValid = hash_equals($hash, $signatureData);
 
         if ($isSignatureValid) {
             // Verifica la fecha de vencimiento
             $currentTimestamp = time();
             $expirationTimestamp = $payloadData['exp'];
             if ($currentTimestamp <= $expirationTimestamp) {
                 // El token no ha expirado
                 return $payloadData['sub']; // identificador del usuario del payload
             } else {
                 return null;
             }
         } else {
             return null;
         }
    }
}
