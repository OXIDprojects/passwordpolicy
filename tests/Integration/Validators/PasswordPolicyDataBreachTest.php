<?php

namespace OxidProfessionalServices\PasswordPolicy\Tests;

use DivineOmega\PasswordExposed\PasswordExposedChecker;
use OxidProfessionalServices\PasswordPolicy\Api\PasswordCheck;
use OxidProfessionalServices\PasswordPolicy\Core\PasswordPolicyConfig;
use OxidProfessionalServices\PasswordPolicy\Validators\PasswordPolicyDataBreach;
use PHPUnit\Framework\TestCase;

class PasswordPolicyDataBreachTest extends TestCase
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
        $this->subjectUnderTest = new PasswordPolicyDataBreach();
    }

    /**
     * @param $username
     * @param $password
     * @param $known
     * @dataProvider credentialsData
     */
    public function testCredentialsCheck($username, $password, $known): void
    {
        $result = $this->subjectUnderTest->validate($username, $password);
        if ($known) {
            $this->assertInternalType('string', $result);
        } else {
            $this->assertTrue($result);
        }
    }

    public function credentialsData()
    {
        return [
            ['', 'test', true],
            ['', 'Test1234!', true],
            ['', 'Manfred', true],
            ['', 'Seltsam', true],
            ['','Test124020!',false],
            ['','h38nn?hdos9!', false],
            ['','975673fh29!', false]
        ];
    }
}
