 <!-- Delete confirmation modal -->
 <div class="modal fade delete-modal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Enter OTP code to delete user.</p>
                <div class="alert alert-danger" style="display: none;"></div>
                <form id="delete-form">
                    @csrf
                    <div class="form-group">
                        <label for="otp-code">OTP Code</label>
                        <input type="text" class="form-control otp-code" id="otp-code" name="otp_code">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger delete-confirm-btn">Delete</button>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('assets/libs/jquery/jquery.min.js')}}"></script>
<script>
    $(function () {
        // Show delete confirmation modal when delete button is clicked
        $('.delete-user-btn').click(function () {
            var userId = $(this).data('id');
            $('.delete-confirm-btn').data('id', userId);

            // Send AJAX request to server to generate and send OTP code to admin
            $.ajax({
                url: '/admin/users/' + userId + '/delete',
                type: 'POST',
                data: {"_token": "{{ csrf_token() }}",},
                success: function (data) {
                    // Show delete confirmation modal and set focus to OTP input field
                    $('.delete-modal').modal('show');
                    $('.otp-code').focus();
                    toastr.options.closeButton = true;
                    toastr.options.closeMethod = 'fadeOut';
                    toastr.options.closeDuration = 100;
                    toastr.success(data.message);
                },
                error: function () {
                    alert('Failed to send OTP code to admin. Please try again later.');
                }
            });
        });
        // Handle form submission for deleting user
        $('.delete-confirm-btn').click(function () {
            var userId = $(this).data('id');
            var otpCode = $('.otp-code').val();

            // Send AJAX request to server to delete user
            $.ajax({
                url: '/admin/users/' + userId,
                type: 'DELETE',
                data: {otp_code: otpCode,"_token": "{{ csrf_token() }}",},
                success: function (data) {
                    // Redirect to user index page on success
                    window.location.href = '/admin/users';
                },
                error: function (xhr) {
                    // Display error message in modal
                    $('#delete-modal .alert-danger').text(xhr.responseJSON.error).show();
                }
            });
        });
    });
</script>