$('#emailAddressPendingVerificationLabel').show();
$('#emailAddressPendingVerification').text(<?= json_encode($email_address) ?>);
$(':input[name="email_address"]').val(<?= json_encode($old_email_address) ?>);