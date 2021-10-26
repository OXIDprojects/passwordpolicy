<?php

namespace OxidProfessionalServices\PasswordPolicy\Tests;

use OxidProfessionalServices\PasswordPolicy\Core\PasswordPolicyConfig;
use PHPUnit\Framework\TestCase;
use OxidProfessionalServices\PasswordPolicy\Validators\PasswordPolicySpecialCharacter;

class PasswordPolicySpecialCharacterTest extends TestCase
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
        $this->subjectUnderTest = new PasswordPolicySpecialCharacter(new PasswordPolicyConfig());
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
            ['L!ama', true],
            ['L1ama', false],
            ['t3st', false],
            ['HalloLeut3', false],
            ['pf!ped', true],

        ];
    }
}
