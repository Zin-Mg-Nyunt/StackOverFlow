<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your OTP Code</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Instrument Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; background-color: #F5F5F5;">
    <table role="presentation" style="width: 100%; border-collapse: collapse; background-color: #F5F5F5; padding: 20px 0;">
        <tr>
            <td align="center">
                <table role="presentation" style="max-width: 600px; width: 100%; border-collapse: collapse; background-color: #FFFFFF; border-radius: 8px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08); border: 1px solid #EDEDED;">
                    <!-- Header with accent color -->
                    <tr>
                        <td style="padding: 40px 30px 30px; text-align: center; background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%); border-radius: 8px 8px 0 0;">
                            <h1 style="margin: 0; font-size: 26px; font-weight: 600; color: #FFFFFF; letter-spacing: -0.5px;">
                                Verification Code
                            </h1>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 30px;">
                            <p style="margin: 0 0 20px; font-size: 16px; line-height: 24px; color: #171717;">
                                Hello,
                            </p>
                            <p style="margin: 0 0 30px; font-size: 16px; line-height: 24px; color: #171717;">
                                You've requested a verification code. Use the code below to complete your request:
                            </p>
                            
                            <!-- OTP Code Box with blue accent -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin: 30px 0;">
                                <tr>
                                    <td align="center">
                                        <div style="display: inline-block; padding: 24px 48px; background: linear-gradient(135deg, #EFF6FF 0%, #DBEAFE 100%); border: 2px solid #3B82F6; border-radius: 8px; letter-spacing: 8px; box-shadow: 0 4px 6px rgba(59, 130, 246, 0.1);">
                                            <span style="font-size: 36px; font-weight: 700; color: #3B82F6; font-family: 'Courier New', monospace;">
                                                {{ $otp }}
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            
                            <!-- Warning message with destructive color -->
                            <p style="margin: 30px 0 0; font-size: 15px; line-height: 22px; color: #DC2626; font-weight: 700; background-color: #FEF2F2; padding: 14px 18px; border-radius: 6px; border: 1.5px solid #FCA5A5; text-align: center; letter-spacing: 0.4px;">
                                ⚠️ <span style="font-size:16px;">This code will expire <u>after <b>3 minutes</b></u>!</span>
                            </p>
                            <p style="margin: 12px 0 0; font-size: 14px; line-height: 20px; color: #737373;">
                                If you didn't request this code, please ignore this email or contact support if you have concerns.
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="padding: 30px; background-color: #F5F5F5; border-radius: 0 0 8px 8px; border-top: 1px solid #EDEDED;">
                            <p style="margin: 0; font-size: 12px; line-height: 18px; color: #737373; text-align: center;">
                                This is an automated message. Please do not reply to this email.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>

