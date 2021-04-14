<?php

use OxidProfessionalServices\PasswordPolicy\Core\PasswordPolicyConfig;
use PHPUnit\Framework\TestCase;
use Enzoic\Enzoic;
use Enzoic\PasswordType;
class PasswordPolicyAPITest extends TestCase
{

    /**
     * @var PasswordPolicyConfig
     */
    protected $subjectUnderTest;


    /**
     * Set initial objects state.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->subjectUnderTest = new \OxidProfessionalServices\PasswordPolicy\Api\PasswordCheck();
    }

    /**
     * @param $test
     * @param $known
     * @dataProvider passwordData
     */
    public function testPasswordCheckWithKnownPassword($test, $known): void
    {
        $result = $this->subjectUnderTest->isPasswordKnown($test);
        $this->assertEquals($known, $result);
    }

    public function passwordData()
    {
        return [
            ['test', true],
            ['test123456', true],
            ['dokrtngeio39$', false],
            ['test1234!', true],
        ];

    }

}