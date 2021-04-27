<?php

namespace OxidProfessionalServices\PasswordPolicy\Tests;

use OxidProfessionalServices\PasswordPolicy\Validators\PasswordPolicyDigits;
use PHPUnit\Framework\TestCase;

class PasswordPolicyDigitsTest extends TestCase
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
        $this->subjectUnderTest = new PasswordPolicyDigits();
    }

    /**
     * @param $password
     * @param $shouldPass
     * @dataProvider PasswordData
     */
    public function testCredentialsCheck($password, $shouldPass): void
    {
        $result = $this->subjectUnderTest->validate('', $password);
        if ($shouldPass) {
            $this->assertTrue($result);
        } else {
            $this->assertInternalType('string', $result);
        }
    }

    public function PasswordData()
    {
        return [
            ['test', false],
            ['L!ama', false],
            ['L1ama', true],
            ['t3st', true],
            ['HalloLeut3', true],
            ['pf!ped', false],

        ];
    }
}
