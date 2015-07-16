<div class="container">
    <div class="row">
        <div class="col-md-12">
        <h1>Demo Application</h1>
        <hr class="colorgraph" />
        </div>
        <div class="col-md-3">
            <a target="_blank" href="<?php echo base_url(); ?>assets/images/khushal-singh.jpg" title="Khushal Singh"><img class="img-thumbnail img-responsive img-circle" src="<?php echo base_url(); ?>assets/images/khushal-singh.jpg" alt="Khushal Singh" /></a>
            <br/>
            <br/>
            <p class="lead pull-right"><strong>Khushal Singh</strong></p>
            <div class="clearfix"></div>
            <p class="lead pull-right">Phone : +91-998-866-5308</p>
            <div class="clearfix"></div>
            <p class="lead pull-right">Email : ksingh.cec@gmail.com</p>
            <div class="clearfix"></div>
            <p class="lead pull-right">Skype : khushalsinghthakur</p>
            <div class="clearfix"></div>
        </div>
        <div class="col-md-9">
            <div>
                <div id="author">
                    <p>Hi,<br/>I'm Khushal Singh.</p>
                    <small>Writer of some amazing application scripts since 2009.</small>
                </div>
                <div id="about" style="display: none">
                    <p class="lead"><strong>About Me</strong></p>
                    <ol>
                        <li>5+ years proficiency in PHP, SQL, HTML, CSS development. Experience w/LAMP stack (Linux/Unix, Apache, Nginx).</li>
                        <li>PHP Proficiency : CakePHP, Codeigniter, Custom MVC Frameworks, OOP in PHP, XMLRPC, SOAP, WSDL, Scripts Performance and Benchmarking by writing code that utilise less resources while execution providing high speed websites/services. Experience implementing major 3rd party APIs (Facebook, Twitter, Google Plus, Google Maps, YouTube, etc.).</li>
                        <li>Javascript Proficiency : Advanced jQuery, jQuery UI, jQuery Mobile, Sencha ExtJS. AJAX calls. RESTful APIs Integration (JSON and XML)</li>
                        <li>Databases Proficiency : MySQL 5 , Windows SQL Server 2008, Views, Triggers, Indexes , Key Constraints , Normalisation upto 3rd level.</li>
                        <li>Designing Proficiency : Photoshop CS6 Basic (layered), Bootstrap 2.1.3 and 3+ , HTML5 and CSS3 , Mediaqueries , HTML 5, HTML 4.01, XHTML 1.0/1.1 etc.</li>
                        <li>Technologies Proficiency : Phonegap (Deployment on Android and iOS Devices), Using PuTTY for maintaining VPS and Cloud Hosting via SSH. Using Git, SVN and Mercurial for source control.</li>
                        <li>Successful Implementation of SEO Techniques such as optimising images, CSS , HTML , clean conventions and deploying techniques specified by Google. Using Google Webmaster tools with custom tracking codes.</li>
                        <li>Knowledge and basic understanding of other languages and tools including C++, Perl, Python, ASP, flash, online videos.</li>
                        <li>Experience and ability to take a project from scoping requirements through actual launch of the project.</li>
                        <li>Knowledge of professional software engineering practices & best practices for the full software development life cycle, including architecture, coding standards, code reviews, source control management, build processes, testing, and operations.</li>
                        <li>Create, test, debug and maintain code and scripts.</li>
                        <li>Mastery of Cross browser development including special considerations for the various quirks.</li>
                        <li>Ability to solve complex, multi-dimensional problems and understanding of algorithm design.</li>
                        <li>Keep up-to-date with the latest relevant technologies and implement web development best practices.</li>
                        <li>Knowledge of security based issues including sessions,cookies and encryption.</li>
                        <li>Computer Science fundamentals in object-oriented design and data structures.</li>
                        <li>Solid understanding of digital storefronts, transaction and e-payment systems.</li>
                    </ol>
                </div>
                <div id="features" style="display: none">
                    <p class="lead"><strong>Application Features</strong></p>
                    <div class="panel-group" id="accordion">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#accordion_image_captcha">
                                        Image Captcha
                                    </a>
                                </h4>
                            </div>
                            <div id="accordion_image_captcha" class="panel-collapse collapse in">
                                <div class="panel-body">
                                    <ul>
                                        <li>For disabling automatic robots(hacks) to fill the forms and submit them.</li>
                                        <li>Enhanced layer of security as they change with every new request.</li>
                                        <li>Keeping it simple for user to fill, only numeric captcha is shown.</li>
                                        <li>Image captcha have distinct fonts which helps in reduced spam attacks.</li>
                                        <li>Image captcha words do not have defined letter positions which helps in reduced spam attacks.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#accordion_login">
                                        Login
                                    </a>
                                </h4>
                            </div>
                            <div id="accordion_login" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <ul>
                                        <li>User can login with both email id OR username.</li>
                                        <li>Remember Me checkbox works well and keeps user logged in for next 15 days until cookies are manually cleared.</li>
                                        <li>If Login attempt fails for more than 3 times then a image captcha is shown for enhanced security.</li>
                                        <li>Login Username/Email/Password should be at least 5 characters.</li>
                                        <li>After successful login user is taken to Dashboard.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#accordion_forgot_password">
                                        Forgot Password
                                    </a>
                                </h4>
                            </div>
                            <div id="accordion_forgot_password" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <ul>
                                        <li>Username OR email address is required to get the password reset instructions.</li>
                                        <li>Username/Email should be at least 5 characters.</li>
                                        <li>Image captcha validation is applied for enhanced security.</li>
                                        <li>When the form is submitted successfully an email is sent out for reset password link to registered email address and the user is redirected to login page.</li>
                                        <li>In case the user account is suspended, user will be shown error message.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#accordion_reset_password">
                                        Reset Password
                                    </a>
                                </h4>
                            </div>
                            <div id="accordion_reset_password" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <ul>
                                        <li>This link is sent in email to user and allows to reset the password.</li>
                                        <li>The link contains unique random long string to identify the user.</li>
                                        <li>This link will expire once the password reset is successful.</li>
                                        <li>In case the user account is not verified by email at registration, then it gets verified automatically.</li>
                                        <li>If user fails resetting password more than 3 times, then this link will expire automatically.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#accordion_create_account">
                                        Create Account (Register)
                                    </a>
                                </h4>
                            </div>
                            <div id="accordion_create_account" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <ul>
                                        <li>Website visitors can register themselves manually on this link.</li>
                                        <li>Usernames are unique in whole application.</li>
                                        <li>Password Needs to be entered twice.</li>
                                        <li>Email Address is unique in whole application. One Application User can only have one unique email address.</li>
                                        <li>User can Opt for occasional newsletters and other informations via email.</li>
                                        <li>Once Account is created, An Account verification email is sent to the newly registered Email address.</li>
                                        <li>If user clicks the verification link sent in the Account verification email then the newly created account is activated and user can use login link to see the secure dashboard.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#accordion_change_password">
                                        Change Password
                                    </a>
                                </h4>
                            </div>
                            <div id="accordion_change_password" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <ul>
                                        <li>Users can change account password after login to their accounts.</li>
                                        <li>Old Password is required to set new password.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#accordion_edit_profile">
                                        Edit Profile
                                    </a>
                                </h4>
                            </div>
                            <div id="accordion_edit_profile" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <ul>
                                        <li>Users can edit their profiles after login to their accounts.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#accordion_acl">
                                        Access Control List
                                    </a>
                                </h4>
                            </div>
                            <div id="accordion_acl" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <ul>
                                        <li>This list is managed by Administrators of the application.</li>
                                        <li>This is the Unique and Robust feature of the application which manages the access to various activities by different application visitors.</li>
                                        <li>Each Action done by a user depends on the URLs (web addresses) they access via their browsers.</li>
                                        <li>Each user belongs to a group. Here we have Administrator, Manager and User.</li>
                                        <li>When a user tries to access a URL then It is checked that the logged in user have enough rights to see the link / perform actions.</li>
                                        <li>If the user do not have access to that URL / Action then user is redirected to Not Authorized Page.</li>
                                        <li>All Urls are kept inside certain URL Sets so that the URLs can be categorized.</li>
                                        <li>Administrator User can give Access OR Revoke Access to any URL for a specific user or the whole user group.</li>
                                        <li>If a user is banned to see a specific URL then he/she will not be able to access that URL even if the Group have access</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#accordion_users_groups">
                                        Users and Groups
                                    </a>
                                </h4>
                            </div>
                            <div id="accordion_users_groups" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <ul>
                                        <li>Administrator can View tabular list of user and groups.</li>
                                        <li>Administrator can create New User/Group.</li>
                                        <li>Administrator can download users/groups list as PDF or Excel</li>
                                        <li>Administrator can set permissions for Users/Groups.</li>
                                        <li>Administrator can search Users/Groups by names or other details.</li>
                                        <li>Administrator can Change password of any user and can send notification email to the user.</li>
                                        <li>Administrator can Edit/Delete profile of any user.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#accordion_emails">
                                        Emails Management
                                    </a>
                                </h4>
                            </div>
                            <div id="accordion_emails" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <ul>
                                        <li>Administrator can View/Download/Search Email Reports.</li>
                                        <li>Emails can be sent via any SMTP Server or via the application itself.</li>
                                        <li>Emails can be sent via Cron Jobs/Scheduled Tasks.</li>
                                        <li>All Emails are stored in the email queue and contains statuses of Queued/Delivered/Opened/Clicked/Failed.</li>
                                        <li>Application will track Email Opening times and counts.</li>
                                        <li>Application will track Email Click times and counts.</li>
                                        <li>Application will store the browser information for each email open and click.</li>
                                        <li>Application will store IP address and Geo locations (City/Country) for each email clicked OR opened.</li>
                                        <li>Each Email can be viewed in the browser.</li>
                                        <li>Each Email has Unsubscribe Link. Clicking this link will disable user to get occasional newsletters and other informations via email.</li>
                                        <li>System will store Last One month emails only so that system will not get slower and will not have speed and loading issues.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#accordion_geo">
                                        Geo Location
                                    </a>
                                </h4>
                            </div>
                            <div id="accordion_geo" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <ul>
                                        <li>Application have built in User location finding service via IP Address.</li>
                                        <li>Emails have the function to store users City and Country.</li>
                                        <li>User Geo location can be applied to any module if needed.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#accordion_responsive">
                                        Responsive Layout
                                    </a>
                                </h4>
                            </div>
                            <div id="accordion_responsive" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <ul>
                                        <li>Application is based on Twitter bootstrap Version 3.2.0 and is fully responsive.</li>
                                        <li>Application can be run on any device with most of the web browsers. However using latest version of web browsers will yield best user experience.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#accordion_social">
                                        Social Media Integration
                                    </a>
                                </h4>
                            </div>
                            <div id="accordion_social" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <ul>
                                        <li>Application can be easily integrated with various social media platforms.</li>
                                        <li>Application has Facebook&reg; and Google&reg; Login facility.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>