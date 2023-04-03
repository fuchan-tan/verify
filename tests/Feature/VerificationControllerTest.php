<?php

namespace Tests\Feature;


use App\Models\Verification;
use App\Http\Controllers\Api\V1\VerificationController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VerificationControllerTest extends TestCase
{
    
    /**
     * A basic test example.  
     */
    public function test_store(): void
    {
        $dummy=[
            "data"=> [
                "id"=> "63c79bd9303530645d1cca00",
                "name"=> "Certificate of Completion",
                "recipient"=> [
                    "name"=> "Marty McFly",
                    "email"=> "marty.mcfly@gmail.com"
                ],
                "issuer"=> [
                    "name"=> "Accredify",
                    "identityProof"=> [
                        "type"=> "DNS-DID",
                        "key"=> "did:ethr:0x05b642ff12a4ae545357d82ba4f786f3aed84214#controller",
                        "location"=> "ropstore.accredify.io"
                    ]
                ],
                "issued"=> "2022-12-23T00:00:00+08:00"
            ],
            "signature"=> [
                "type"=> "SHA3MerkleProof",
                "targetHash"=> "288f94aadadf486cfdad84b9f4305f7d51eac62db18376d48180cc1dd2047a0e"
            ]
        ];

        //Verified
        $response = $this->json('post','/api/v1/verify',$dummy);
        $result= $response->assertstatus(200)->json('data');
        $this->assertEquals($result['issuer'],$dummy['data']['issuer']['name'],'Issure Names are not equal');
        $this->assertEquals($result['result'],'Verified','Results are not equal');

        //invalid_signature
        $dummy['data']['signature']['targetHash']='';
        $response = $this->json('post','/api/v1/verify',$dummy);
        $result= $response->assertstatus(200)->json('data');
        $this->assertEquals($result['issuer'],$dummy['data']['issuer']['name'],'Issure Names are not equal');
        $this->assertEquals($result['result'],'invalid_signature','Results are not equal');

        //invalid_issuer
        $dummy['data']['issuer']['name']='';
        $response = $this->json('post','/api/v1/verify',$dummy);
        $result= $response->assertstatus(200)->json('data');
        $this->assertEquals($result['result'],'invalid_issuer','Results are not equal');

        //invalid_recipient
        $dummy['data']['recipient']['name']='';
        $response = $this->json('post','/api/v1/verify',$dummy);
        $result= $response->assertstatus(200)->json('data');
        $this->assertEquals($result['result'],'invalid_recipient','Results are not equal');
    }
}