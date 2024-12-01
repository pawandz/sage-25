<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Request a Callback | Sage Titans</title>
    <meta name="description"
        content="Request a callback from Sage Titans to discuss your business needs. Our experts are ready to help you grow!" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main-eng.css" />
    <link href="style.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</head>

<body>
    <!--=============== HEADER ===============-->
    <?php include 'includes/header.php'; ?>
    <!-- Inner Page Banner -->
    <div class="inner-p-banner-fourzerofour"
        style="background: url(images/contact-us-bg.webp) no-repeat center top; background-size: cover;">
        
    </div>
<br><br>
    <!-- Request a Callback Form -->
    <section class="section ff-contact">
        <div class="container">
            <div class="contact-us">
                <div class="contact-us_left">
                    <h2>Let us call you back!</h2>
                    <p>Fill out the form below, and one of our experts will contact you soon.</p>
                </div>
                <div class="contact-us_right">
                    <form class="form form-contact" action="" novalidate>
                        <div class="form-group">
                            <label class="label" for="name">Name*</label>
                            <input class="field" type="text" name="name" id="name" required placeholder="Your Name">
                            <span class="error"></span>
                        </div>
                        <div class="form-group">
                            <label class="label" for="phone">Phone*</label>
                            <input class="field" type="text" name="phone" id="phone" required
                                placeholder="+1 123 456 7890">
                            <span class="error"></span>
                        </div>
                        <div class="form-group">
                            <label class="label" for="email">Email</label>
                            <input class="field" type="email" name="email" id="email"
                                placeholder="youremail@example.com">
                            <span class="error"></span>
                        </div>
                        <div class="form-group">
                            <label class="label" for="date">Preferred Date*</label>
                            <input class="field" type="date" name="date" id="date" required>
                            <span class="error"></span>
                        </div>
                        <div class="form-group">
                            <label class="label" for="time">Preferred Time*</label>
                            <input class="field" type="time" name="time" id="time" required>
                            <span class="error"></span>
                        </div>
                        <div class="form-group">
                            <label class="label" for="comments">Your Query</label>
                            <textarea class="field textarea" name="comments" id="comments" rows="4"
                                placeholder="Let us know how we can help you"></textarea>
                        </div>
                        <div class="form-group">
                            <?php $site_key = '6LfZU20aAAAAADOZ-LLvpF_CcwLifRR_MKa3lsoS'; ?>
                            <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-brand btn-submit">Request Callback</button>
                        </div>
                        <div class="spinner-border text-light" id="spinner-border" role="status" style="display:none">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <div class="alert alert-success" role="alert" style="display:none">Your request has been submitted. We'll contact you shortly!</div>
                        <div class="alert alert-danger" role="alert" style="display:none"></div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <br><br>
    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>

    <!-- Google reCAPTCHA -->
    <script src="https://www.google.com/recaptcha/api.js?render=<?php echo $site_key; ?>"></script>
    <script>
        var siteKey = "<?php echo $site_key; ?>";
        window.onload = function () {
            $('button.btn-submit').click(function (event) {
                $('form.form-contact').find('.error').each(function () {
                    $(this).text('');
                });
                let valid = true;
                $('form.form-contact').find('input,textarea').each(function () {
                    if (!this.checkValidity()) {
                        $(this).siblings('.error').text(this.validationMessage) && (valid = false);
                    }
                });
                if (!valid) {
                    return;
                }

                grecaptcha.ready(function () {
                    grecaptcha.execute(siteKey, { action: 'contact' })
                        .then(function (token) {
                            document.getElementById('g-recaptcha-response').value = token;
                            jQuery.ajax({
                                url: "callback-handler.php",
                                data: 'name=' + $("#name").val() +
                                    '&phone=' + $("#phone").val() +
                                    '&email=' + $("#email").val() +
                                    '&date=' + $("#date").val() +
                                    '&time=' + $("#time").val() +
                                    '&comments=' + $("#comments").val() +
                                    '&recaptcha_response=' + $("#g-recaptcha-response").val(),
                                type: "POST",
                                beforeSend: function () {
                                    $('#spinner-border').show();
                                },
                                complete: function () {
                                    $('#spinner-border').hide();
                                },
                                success: function (result) {
                                    var data = jQuery.parseJSON(result);
                                    if (data.status) {
                                        $("form.form-contact")[0].reset();
                                        $(".alert-success").show();
                                    } else {
                                        $(".alert-danger").text(data.message).show();
                                    }
                                },
                                error: function () {
                                    $(".alert-danger").text("Something went wrong. Please try again.").show();
                                }
                            });
                        });
                });
            });
        };
    </script>
</body>

</html>
