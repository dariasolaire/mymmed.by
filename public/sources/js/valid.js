$(document).ready(function(){

    $('#registerForm').zValid({
            'success': function () {
                $("#registerForm")[0].reset();
            }
        }
    );

    $('#loginForm').zValid({
            'success': function () {
                $("#loginForm")[0].reset();
            }
        }
    );
    $('#resetPasswordForm').zValid({

            'success': function () {
                $("#resetPasswordForm")[0].reset();
            }
        }
    );
    $('#changeInfoForm').zValid({
            'success': function () {
            }
        }
    );
    $('#changePasswordForm').zValid({
            'success': function () {
                $("#changePasswordForm")[0].reset();
            }
        }
    )


    $('#searchUserForm').zValid({
            'success': function () {

            }
        }
    )

    $('#registerUserEventForm').zValid({
            'success': function () {
                $("#registerUserEventForm")[0].reset();
            }
        }
    )
    $('#callForm').zValid({
            'success': function () {
                $('._js-pop-close').click();
                $("#callForm")[0].reset();
            }
        }
    )
});
