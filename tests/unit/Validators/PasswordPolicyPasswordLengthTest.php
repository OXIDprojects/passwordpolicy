<?php

namespace OxidProfessionalServices\PasswordPolicy\Tests;


use PHPUnit\Framework\TestCase;
use OxidProfessionalServices\PasswordPolicy\Validators\PasswordPolicyPasswordLength;

class PasswordPolicyPasswordLengthTest extends TestCase
{
    protected $subjectUnderTest;


    /**
     * Set initial objects state.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->subjectUnderTest = new PasswordPolicyPasswordLength();
    }

    /**
     * @param $password
     * @param $shouldPass
     * @dataProvider PasswordData
     */
    public function testCredentialsCheck($password, $shouldPass): void
    {
        $result = $this->subjectUnderTest->validate('', $password);
        if($shouldPass)
        {
            $this->assertTrue($result);
        }
        else{
            $this->assertInternalType('string', $result);
        }

    }

    public function PasswordData()
    {
        return [
            ['sdfn', false],
            ['hallote', false],
            ['testtest', true],
            ['8Zeichen', true],
            ['255ZeichenSindDoooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooof', false],
            ['pf!ped', false],

        ];

    }
}