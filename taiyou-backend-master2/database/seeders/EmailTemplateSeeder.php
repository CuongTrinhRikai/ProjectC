<?php
namespace Database\Seeders;

use App\Model\EmailTemplate;
use App\Model\EmailTemplateTranslation;
use Illuminate\Database\Seeder;

class EmailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fromEmail = env('MAIL_FROM_ADDRESS') ?? 'info@ekbana.com';
        /**
         * Template for table header
         */
        $templateHeader = '<table class="body" border="0" cellspacing="0" cellpadding="0">
        <tbody>
        <tr>
            <td>&nbsp;</td>
            <td class="container">
            <div class="content">
            <table class="main"><!-- START MAIN CONTENT AREA -->
                        <tbody>
                        <tr>
                            <td class="wrapper">
                                <table border="0" cellspacing="0" cellpadding="0">
                                    <tbody>
                                    <tr>
                                        <td>
';
        /**
         * Template for table footer
         */
        $templateFooter = '<p>Thank you!</p>
                                            <br>
                                            <p class="pull-right">Yours Sincerely,<br>
                                                Team Taiyou</p>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <!-- END MAIN CONTENT AREA --></tbody>
                    </table>
                    <!-- START FOOTER -->
                    <div class="footer">
                        <table border="0" cellspacing="0" cellpadding="0">
                            <tbody>
                            <tr>
                                <td class="content-block"><span class="apple-link">Ekbana</span></td>
                            </tr>
                            <tr>
                                <td class="content-block powered-by">Powered by Ekbana</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- END FOOTER --> <!-- END CENTERED WHITE CONTAINER --></div>
            </td>
            <td>&nbsp;</td>
        </tr>
        </tbody>
    </table>
';
        $templates = [
            [
                'title' => 'Account Created Email',
                'code' => 'AccountCreateEmail',
                'from' => $fromEmail,
                'translations' => [
                    [
                        'language_code' => 'en',
                        'subject' => 'Account has been created in ekcms',
                        'template' => $templateHeader . '
                    <p>Dear %user_name%,</p>
                    <p>Your account has been created in ekcms. Please contact admin to get your credential.</p>
                    ' . $templateFooter
                    ],
                    [
                        'language_code' => 'ja',
                        'subject' => 'Account has been created in ekcms',
                        'template' => $templateHeader . '
                        <p>Dear %user_name%,</p>
                        <p>Your account has been created in ekcms. Please contact admin to get your credential.</p>
                        ' . $templateFooter
                    ]
                ]

            ],
            [
                'title' => 'Password Set Link Email',
                'code' => 'PasswordSetLinkEmail',
                'from' => $fromEmail,
                'translations' => [
                    [
                        'language_code' => 'en',
                        'subject' => 'Password set link',
                        'template' => $templateHeader . '
                        <p>Dear %user_name%,</p>
                        <p>Your account has been created in ekcms. Please click the link below to set your password.</p>
                        <p>Link : %password_set_link%</p>
                            ' . $templateFooter
                    ],
                    [
                        'language_code' => 'ja',
                        'subject' => 'Password set link',
                        'template' => $templateHeader . '
                        <p>Dear %user_name%,</p>
                        <p>Your account has been created in ekcms. Please click the link below to set your password.</p>
                        <p>Link : %password_set_link%</p>
                            ' . $templateFooter
                    ]
                ]

            ],
            [
                'title' => 'Password ResetLink Email',
                'code' => 'PasswordResetLinkEmail',
                'from' => $fromEmail,
                'translations' => [
                    [
                        'language_code' => 'en',
                        'subject' => 'Password Reset Link',
                        'template' => $templateHeader . '
                                        <p>Dear %user_name%,</p>
                                        <p>As per your request we have generated a password reset link. Please click the link below to reset your password.</p>
                                        <p>Link : %password_reset_link%</p>
                                            ' . $templateFooter
                    ],
                    [
                        'language_code' => 'ja',
                        'subject' => 'Password Reset Link',
                        'template' => $templateHeader . '
                                        <p>Dear %user_name%,</p>
                                        <p>As per your request we have generated a password reset link. Please click the link below to reset your password.</p>
                                        <p>Link : %password_reset_link%</p>
                                            ' . $templateFooter
                    ]
                ]

            ],
            [
                'title' => 'Two Factor Authentication Email',
                'code' => 'TwoFAEmail',
                'from' => $fromEmail,
                'translations' => [
                    [
                        'language_code' => 'en',
                        'subject' => 'Verification Code',
                        'template' => $templateHeader . '
                                <p>Dear %user_name%,</p>
                                <p>Please copy the verification code below.</p>
                                <p>Code : %verification_code%</p>
                                    ' . $templateFooter
                    ],
                    [
                        'language_code' => 'ja',
                        'subject' => 'Verification Code',
                        'template' => $templateHeader . '
                                <p>Dear %user_name%,</p>
                                <p>Please copy the verification code below.</p>
                                <p>Code : %verification_code%</p>
                                    ' . $templateFooter
                    ]
                ]

            ],
            [
                'title' => 'Checkin',
                'code' => 'Checkin',
                'from' => $fromEmail,
                'translations' => [
                    [
                        'language_code' => 'en',
                        'subject' => '%building_admin_name%',
                        'template' => $templateHeader . '
                        Dear Superuser,
                       <p> Building Admin Check In / Check Out Information:</p>
                            <p> Building Admin : %building_admin_name%</p>
                            <p> Building Admin ID  :  %building_admin_id%</p>
                            <p> Business Category  :  %business_category%</p>
                            <p> Mansion ID   :  %mansion_id%</p>
                            <p> Mansion Name   :  %mansion_name%</p>
                            <p> Contractor ID   : %contractor_id%</p>
                            <p> Latitude : %latitude%</p>
                            <p>Longitude :  %longitude%</p>
                            <p>Check In Time  : %check_in%</p>


                    ' . $templateFooter
                    ],
                    [
                        'language_code' => 'ja',
                        'subject' => '%building_admin_name%',
                        'template' => $templateHeader . '
                        Dear Superuser,
                        <p> Building Admin Check In / Check Out Information:</p>
                            <p> Building Admin : %building_admin_name%</p>
                            <p> Building Admin ID  :  %building_admin_id%</p>
                            <p> Business Category  :  %business_category%</p>
                            <p> Mansion ID   :  %mansion_id%</p>
                            <p> Mansion Name   :  %mansion_name%</p>
                            <p> Contractor ID   : %contractor_id%</p>
                            <p> Latitude : %latitude%</p>
                            <p>Longitude :  %longitude%</p>
                            <p>Check In Time  : %check_in%</p>

                    ' . $templateFooter
                    ]
                ]

            ],
        ];

        foreach ($templates as $template) {
            $data = [
                'title' => $template['title'],
                'code' => $template['code'],
                'from' => 'admintokyo@mailinator.com',
                'company_id' => 2

            ];
            $email = EmailTemplate::create($data);
            $email->emailTranslations()->createMany($template['translations']);
        }

        foreach ($templates as $template) {
            $data = [
                'title' => $template['title'],
                'code' => $template['code'],
                'from' => 'adminlink@mailinator.com',
                'company_id' => 3

            ];
            $email = EmailTemplate::create($data);
            $email->emailTranslations()->createMany($template['translations']);
        }
    }
}
