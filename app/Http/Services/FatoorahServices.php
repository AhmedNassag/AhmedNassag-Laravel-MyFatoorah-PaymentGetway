<?php

namespace App\Http\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Config;

class FatoorahServices
{
    private $base_url;
    private $headers;
    private $request_client;

    /**
     * FatoorahServices constructor.
     */
    public function __construct(Client $request_client)
    {
        $this->request_client = $request_client;
        $this->base_url = /*env('FATOORAH_BASE_URL')*/'https://apitest.myfatoorah.com';
        $this->headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . /*env('FATOORAH_TOKEN')*/
            /*
            'dpRmD_LU9a45p1X27yXC_7w_QhDQzndB2bS_Aky0GWdlRP_loBKbGYtMgIxWMp74PnWlcm19WlPNq_Zo03wtDXblw8AhVF6qRIBk5O7X9i8RWDWbHJtJCpJVCVxFueO7nUeDjV41JgKvKn3rRaRLBDpx4DPaYQTPhMg5L8LLeTdKZgD4FIlw3eH_FB5TqypMx3_dBLytQ-nigzPrEZ29Z2nXcV49X92Rha6XZGzLRhMi8bjLTTAdLm9foTZBXVktyU7SQDFCqATXnJeYnrfpzvZ_ShtLCL-c7Ct_HApfzJjjrIrRW0qTj-yjKYRff2nR7n3Tf0q5jF18830LqlynXWWWqm9ArckQhiEevRJUQ1mW5YOMzPROo-YIsDObL3XfVbOnZigPAngTTLx9_uMx2d32akhU2LJTiEC7dNymny8iL0ehALUPSXnp7mli0HvcbKtUUwcQu58Gy-NXOIBvPV2-3U19NifyzMulR-u5DFuK_77Qb1nrNWYhjDPQe0DnGLORMJyvgbj9V2j3-YI0A-V6yfW1ZOJjk-A70WWB9RSxp36-ANcCrl1QKuuYW2q06RyaZ6cBAyzXH6m8GvDPHEgon6aEUqluoLQBhSXyCNzkeLav7a6zywYEdZnfsAbr52RZxFhpXuhzMKmLcTs5bXSNPjyo-fkYO0V5rXm-xl8CTmd7d4FgTHcftvAvodqNVAFgDg'
            */

            'rLtt6JWvbUHDDhsZnfpAhpYk4dxYDQkbcPTyGaKp2TYqQgG7FGZ5Th_WD53Oq8Ebz6A53njUoo1w3pjU1D4vs_ZMqFiz_j0urb_BH9Oq9VZoKFoJEDAbRZepGcQanImyYrry7Kt6MnMdgfG5jn4HngWoRdKduNNyP4kzcp3mRv7x00ahkm9LAK7ZRieg7k1PDAnBIOG3EyVSJ5kK4WLMvYr7sCwHbHcu4A5WwelxYK0GMJy37bNAarSJDFQsJ2ZvJjvMDmfWwDVFEVe_5tOomfVNt6bOg9mexbGjMrnHBnKnZR1vQbBtQieDlQepzTZMuQrSuKn-t5XZM7V6fCW7oP-uXGX-sMOajeX65JOf6XVpk29DP6ro8WTAflCDANC193yof8-f5_EYY-3hXhJj7RBXmizDpneEQDSaSz5sFk0sV5qPcARJ9zGG73vuGFyenjPPmtDtXtpx35A-BVcOSBYVIWe9kndG3nclfefjKEuZ3m4jL9Gg1h2JBvmXSMYiZtp9MR5I6pvbvylU_PP5xJFSjVTIz7IQSjcVGO41npnwIxRXNRxFOdIUHn0tjQ-7LwvEcTXyPsHXcMD8WtgBh-wxR8aKX7WPSsT1O8d8reb2aR7K3rkV3K82K_0OgawImEpwSvp9MNKynEAJQS6ZHe_J_l77652xwPNxMRTMASk1ZsJL'

        ];
    }





    private function buildRequest($url, $method, $data = [])
    {
        $request = new Request($method, $this->base_url . $url, $this->headers);
        if (!$data) {
            return false;
        }

        $response = $this->request_client->send($request, [
            'json' => $data
        ]);

        if($response->getStatusCode() != 200)
        {
            return false;
        }

        $response = json_decode($response->getBody(), true);
        return $response;
    }





    public function sendPayment($data)
    {
        return $this->buildRequest('/v2/SendPayment', 'POST', $data);
    }





    public function getPaymentStatus($data)
    {
        return $this->buildRequest('/v2/getPaymentStatus', 'POST', $data);
    }
}
