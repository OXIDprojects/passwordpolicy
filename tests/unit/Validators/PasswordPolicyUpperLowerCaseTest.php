<?php

namespace OxidProfessionalServices\PasswordPolicy\Tests;


use PHPUnit\Framework\TestCase;
use OxidProfessionalServices\PasswordPolicy\Validators\PasswordPolicyUpperLowerCase;

class PasswordPolicyUpperLowerCaseTest extends TestCase
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
        $this->subjectUnderTest = new PasswordPolicyUpperLowerCase();
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
            ['test', false],
            ['Lama', true],
            ['l1ama', false],
            ['t3st', false],
            ['HalloLeut3', true],
            ['pf!ped', false],

        ];

    }
}