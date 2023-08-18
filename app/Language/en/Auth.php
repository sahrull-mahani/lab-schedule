<?php

/**
 * Name:  Auth Lang - English
 *
 * Author: Ben Edmunds
 *         ben.edmunds@gmail.com
 *         @benedmunds
 *
 * Author: Daniel Davis
 *         @ourmaninjapan
 *
 * Location: http://github.com/benedmunds/ion_auth/
 *
 * Created:  03.09.2013
 *
 * Description:  English language file for Ion Auth example views
 *
 * @package Codeigniter-Ion-Auth
 */

return [
	// Errors
	'error_security' => 'This form post did not pass our security checks.',

	// Login
	'login_heading'         => 'Login',
	'login_subheading'      => 'Please login with your email/username and password below.',
	'login_identity_label'  => 'Email/Username:',
	'login_password_label'  => 'Password:',
	'login_remember_label'  => 'Remember Me:',
	'login_submit_btn'      => 'Login',
	'login_forgot_password' => 'Forgot your password?',

	// Index
	'index_heading'           => 'Users',
	'index_subheading'        => 'Below is a list of the users.',
	'index_name_th'           => 'Name',
	'index_fname_th'          => 'First Name',
	'index_lname_th'          => 'Last Name',
	'index_email_th'          => 'Email',
	'index_groups_th'         => 'Groups',
	'index_status_th'         => 'Status',
	'index_action_th'         => 'Action',
	'index_active_link'       => 'Active',
	'index_edit_link'         => 'Edit',
	'index_inactive_link'     => 'Inactive',
	'index_create_user_link'  => 'Create a new user',
	'index_create_group_link' => 'Create a new group',

	// Deactivate User
	'deactivate_heading'                  => 'Deactivate User',
	'deactivate_subheading'               => 'Are you sure you want to deactivate the user \'%s\'',
	'deactivate_confirm_y_label'          => 'Yes:',
	'deactivate_confirm_n_label'          => 'No:',
	'deactivate_submit_btn'               => 'Submit',
	'deactivate_validation_confirm_label' => 'confirmation',
	'deactivate_validation_user_id_label' => 'user ID',

	// Create User
	'create_user_heading'                           => 'Create User',
	'create_user_subheading'                        => 'Please enter the user\'s information below.',
	'create_user_name_label'                        => 'Name:',
	'create_user_department_label'                  => 'Department name:',
	'create_user_identity_label'                    => 'Identity:',
	'create_user_email_label'                       => 'Email:',
	'create_username_label'                         => 'username:',
	'create_user_phone_label'                       => 'Phone:',
	'create_user_password_label'                    => 'Password:',
	'create_user_password_confirm_label'            => 'Confirm Password:',
	'create_user_submit_btn'                        => 'Create User',
	'create_user_validation_name_label'             => 'Name',
	'create_user_validation_identity_label'         => 'Identity',
	'create_user_validation_email_label'            => 'Email Address',
	'create_user_validation_phone_label'            => 'Phone',
	'create_user_validation_department_label'       => 'Department Name',
	'create_user_validation_password_label'         => 'Password',
	'create_user_validation_password_confirm_label' => 'Password Confirmation',

	// Edit User
	'edit_user_heading'                           => 'Edit User',
	'edit_user_subheading'                        => 'Please enter the user\'s information below.',
	'edit_user_name_label'                        => 'Name:',
	'edit_user_department_label'                  => 'Department name:',
	'edit_user_email_label'                       => 'Email:',
	'edit_username_label'                         => 'username:',
	'edit_user_phone_label'                       => 'Phone:',
	'edit_user_password_label'                    => 'Password: (if changing password)',
	'edit_user_password_confirm_label'            => 'Confirm Password: (if changing password)',
	'edit_user_groups_heading'                    => 'Member of groups',
	'edit_user_submit_btn'                        => 'Save User',
	'edit_user_validation_name_label'             => 'Name',
	'edit_user_validation_email_label'            => 'Email Address',
	'edit_user_validation_phone_label'            => 'Phone',
	'edit_user_validation_department_label'       => 'Department name:',
	'edit_user_validation_groups_label'           => 'Groups',
	'edit_user_validation_password_label'         => 'Password',
	'edit_user_validation_password_confirm_label' => 'Password Confirmation',

	// Create Group
	'create_group_title'                  => 'Create Group',
	'create_group_heading'                => 'Create Group',
	'create_group_subheading'             => 'Please enter the group information below.',
	'create_group_name_label'             => 'Group Name:',
	'create_group_desc_label'             => 'Description:',
	'create_group_submit_btn'             => 'Create Group',
	'create_group_validation_name_label'  => 'Group Name',
	'create_group_validation_desc_label'  => 'Description',

	// Edit Group
	'edit_group_title'                  => 'Edit Group',
	'edit_group_saved'                  => 'Group Saved',
	'edit_group_heading'                => 'Edit Group',
	'edit_group_subheading'             => 'Please enter the group information below.',
	'edit_group_name_label'             => 'Group Name:',
	'edit_group_desc_label'             => 'Description:',
	'edit_group_submit_btn'             => 'Save Group',
	'edit_group_validation_name_label'  => 'Group Name',
	'edit_group_validation_desc_label'  => 'Description',

	// Change Password
	'change_password_heading'                               => 'Change Password',
	'change_password_old_password_label'                    => 'Old Password:',
	'change_password_new_password_label'                    => 'New Password (at least %s characters long):',
	'change_password_new_password_confirm_label'            => 'Confirm New Password:',
	'change_password_submit_btn'                            => 'Change',
	'change_password_validation_old_password_label'         => 'Old Password',
	'change_password_validation_new_password_label'         => 'New Password',
	'change_password_validation_new_password_confirm_label' => 'Confirm New Password',

	// Forgot Password
	'forgot_password_heading'                 => 'Forgot Password',
	'forgot_password_subheading'              => 'Please enter your %s so we can send you an email to reset your password.',
	'forgot_password_email_label'             => '%s:',
	'forgot_password_submit_btn'              => 'Submit',
	'forgot_password_validation_email_label'  => 'Email Address',
	'forgot_password_identity_label'          => 'Identity',
	'forgot_password_email_identity_label'    => 'Email',
	'forgot_password_email_not_found'         => 'No record of that email address.',
	'forgot_password_identity_not_found'         => 'No record of that username.',

	// Reset Password
	'reset_password_heading'                               => 'Change Password',
	'reset_password_new_password_label'                    => 'New Password (at least %s characters long):',
	'reset_password_new_password_confirm_label'            => 'Confirm New Password:',
	'reset_password_submit_btn'                            => 'Change',
	'reset_password_validation_new_password_label'         => 'New Password',
	'reset_password_validation_new_password_confirm_label' => 'Confirm New Password',

    // Exceptions
    'invalidModel'              => 'The {0} model must be loaded prior to use.',
    'userNotFound'              => 'Unable to locate a user with ID = {0, number}.',
    'noUserEntity'              => 'User Entity must be provided for password validation.',
    'tooManyCredentials'        => 'You may only validate against 1 credential other than a password.',
    'invalidFields'             => 'The "{0}" field cannot be used to validate credentials.',
    'unsetPasswordLength'       => 'You must set the `minimumPasswordLength` setting in the Auth config file.',
    'unknownError'              => 'Sorry, we encountered an issue sending the email to you. Please try again later.',
    'notLoggedIn'               => 'You must be logged in to access that page.',
    'notEnoughPrivilege'        => 'You do not have sufficient permissions to access that page.',

    // Registration
    'registerDisabled'          => 'Sorry, new user accounts are not allowed at this time.',
    'registerSuccess'           => 'Welcome aboard! Please login with your new credentials.',
    'registerCLI'               => 'New user created: {0}, #{1}',

    // Activation
    'activationNoUser'          => 'Unable to locate a user with that activation code.',
    'activationSubject'         => 'Activate your account',
    'activationSuccess'         => 'Please confirm your account by clicking the activation link in the email we have sent.',
    'activationResend'          => 'Resend activation message one more time.',
    'notActivated'              => 'This user account is not yet activated.',
    'errorSendingActivation'    => 'Failed to send activation message to: {0}',

    // Login
    'badAttempt'                => 'Unable to log you in. Please check your credentials.',
    'loginSuccess'              => 'Welcome back!',
    'invalidPassword'           => 'Unable to log you in. Please check your password.',

    // Forgotten Passwords
    'forgotDisabled'            => 'Reseting password option has been disabled.',
    'forgotNoUser'              => 'Unable to locate a user with that email.',
    'forgotSubject'             => 'Password Reset Instructions',
    'resetSuccess'              => 'Your password has been successfully changed. Please login with the new password.',
    'forgotEmailSent'           => 'A security token has been emailed to you. Enter it in the box below to continue.',
    'errorEmailSent'            => 'Unable to send email with password reset instructions to: {0}',
    'errorResetting'            => 'Unable to send reset instructions to {0}',

    // Passwords
    'errorPasswordLength'       => 'Passwords must be at least {0, number} characters long.',
    'suggestPasswordLength'     => 'Pass phrases - up to 255 characters long - make more secure passwords that are easy to remember.',
    'errorPasswordCommon'       => 'Password must not be a common password.',
    'suggestPasswordCommon'     => 'The password was checked against over 65k commonly used passwords or passwords that have been leaked through hacks.',
    'errorPasswordPersonal'     => 'Passwords cannot contain re-hashed personal information.',
    'suggestPasswordPersonal'   => 'Variations on your email address or username should not be used for passwords.',
    'errorPasswordTooSimilar'    => 'Password is too similar to the username.',
    'suggestPasswordTooSimilar'  => 'Do not use parts of your username in your password.',
    'errorPasswordPwned'        => 'The password {0} has been exposed due to a data breach and has been seen {1, number} times in {2} of compromised passwords.',
    'suggestPasswordPwned'      => '{0} should never be used as a password. If you are using it anywhere change it immediately.',
    'errorPasswordPwnedDatabase' => 'a database',
    'errorPasswordPwnedDatabases' => 'databases',
    'errorPasswordEmpty'        => 'A Password is required.',
    'passwordChangeSuccess'     => 'Password changed successfully',
    'userDoesNotExist'          => 'Password was not changed. User does not exist',
    'resetTokenExpired'         => 'Sorry. Your reset token has expired.',

    // Groups
    'groupNotFound'             => 'Unable to locate group: {0}.',

    // Permissions
    'permissionNotFound'        => 'Unable to locate permission: {0}',

    // Banned
    'userIsBanned'              => 'User has been banned. Contact the administrator',

    // Too many requests
    'tooManyRequests'           => 'Too many requests. Please wait {0, number} seconds.',

    // Login views
    'home'                      => 'Home',
    'current'                   => 'Current',
    'forgotPassword'            => 'Forgot Your Password?',
    'enterEmailForInstructions' => 'No problem! Enter your email below and we will send instructions to reset your password.',
    'email'                     => 'Email',
    'emailAddress'              => 'Email Address',
    'sendInstructions'          => 'Send Instructions',
    'loginTitle'                => 'Login',
    'loginAction'               => 'Login',
    'rememberMe'                => 'Remember me',
    'needAnAccount'             => 'Need an account?',
    'forgotYourPassword'        => 'Forgot your password?',
    'password'                  => 'Password',
    'repeatPassword'            => 'Repeat Password',
    'emailOrUsername'           => 'Email or username',
    'username'                  => 'Username',
    'register'                  => 'Register',
    'signIn'                    => 'Sign In',
    'alreadyRegistered'         => 'Already registered?',
    'weNeverShare'              => 'We\'ll never share your email with anyone else.',
    'resetYourPassword'         => 'Reset Your Password',
    'enterCodeEmailPassword'    => 'Enter the code you received via email, your email address, and your new password.',
    'token'                     => 'Token',
    'newPassword'               => 'New Password',
    'newPasswordRepeat'         => 'Repeat New Password',
    'resetPassword'             => 'Reset Password',
];
