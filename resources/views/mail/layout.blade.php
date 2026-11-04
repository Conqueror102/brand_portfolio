<!DOCTYPE html>
<html lang="en">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"></head>
<body style="margin:0;background:#F3F1ED;font-family:Helvetica,Arial,sans-serif;color:#102440;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="padding:32px 12px;">
    <tr><td align="center">
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:560px;background:#FFFFFF;border-radius:18px;overflow:hidden;">
            <tr><td style="background:#102440;color:#F4F1EC;padding:24px 32px;font-family:Georgia,serif;font-size:22px;">{{ content('profile.given_name') }} {{ content('profile.surname') }}</td></tr>
            <tr><td style="padding:32px;font-size:15px;line-height:1.6;">@yield('body')</td></tr>
            <tr><td style="padding:20px 32px;background:#FCFAF7;color:#526170;font-size:12px;">{{ content('profile.tagline') }}</td></tr>
        </table>
    </td></tr>
</table>
</body>
</html>
