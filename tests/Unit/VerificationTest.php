<?php

namespace Tests\Unit;


use App\Models\Verification;
use App\Http\Requests\Api\V1\verificationRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VerificationTest extends TestCase
{
    
    /**
     * A basic unit test example.
     */
    public function test_store(): void
    {
        
        $model = $this->app->make(Verification::class);
        $dummy=[
            "user_id"=> "63c79bd9303530645d1cca00",
            "file_type"=> "JSON",
            "result"=> "Verified"
        ];
        $result=$model->create($dummy);
        $this->assertEquals($result['user_id'],$dummy['user_id'],'User Ids are not equal');
        $this->assertEquals($result['file_type'],$dummy['file_type'],'File Types are not equal');
        $this->assertEquals($result['result'],$dummy['result'],'Result values are not equal');
    }
}
