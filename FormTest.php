<?php
use PHPUnit\Framework\TestCase;

class FormTest extends TestCase {
    public function testFormSubmission() {
        // Simular el envío del formulario y verificar la respuesta
        $postData = [
            'nombre' => 'Ejemplo',
            'email' => 'ejemplo@email.com',
            'mensaje' => 'Esto es un mensaje de prueba.'
        ];

        $response = $this->sendPostRequest('procesar_formulario.php', $postData);

        // Verificar si se redirige a la página de confirmación
        $this->assertEquals('Location: confirmacion.html', $response['headers'][0]);

        // Verificar si se escribió en el archivo de registro
        $registros = file_get_contents('registros.txt');
        $this->assertStringContainsString('Ejemplo - ejemplo@email.com - Esto es un mensaje de prueba.', $registros);
    }

    // Método para simular una solicitud POST
    private function sendPostRequest($url, $postData) {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($postData),
        ]);

        $response = curl_exec($curl);
        $info = curl_getinfo($curl);

        curl_close($curl);

        return [
            'headers' => $info['redirect_url'] ? [$info['redirect_url']] : [],
            'body' => $response
        ];
    }
}
