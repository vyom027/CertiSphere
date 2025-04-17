<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>New Certificate Request Notification</title>
    <style>
        /* Reset styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        /* Base typography */
        body {
            font-family: 'Arial', 'Helvetica Neue', Helvetica, sans-serif;
            line-height: 1.6;
            color: #2c3e50;
            background-color: #f5f7fa;
            padding: 20px;
        }
        
        /* Main wrapper */
        .notification-wrapper {
            max-width: 650px;
            margin: 0 auto;
        }
        
        /* Branding header */
        .brand-header {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .brand-logo {
            height: 60px;
            margin-bottom: 5px;
        }
        
        /* Main notification card */
        .notification-card {
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }
        
        /* Top banner */
        .top-banner {
            background: linear-gradient(135deg, #1e5799 0%, #207cca 100%);
            color: white;
            padding: 25px 30px;
            position: relative;
        }
        
        .banner-title {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .banner-subtitle {
            font-size: 14px;
            opacity: 0.9;
        }
        
        .banner-icon {
            position: absolute;
            right: 30px;
            top: 25px;
            font-size: 36px;
            opacity: 0.2;
        }
        
        /* Content section */
        .content-section {
            padding: 30px;
        }
        
        .salutation {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #2c3e50;
        }
        
        .notification-text {
            margin-bottom: 25px;
            color: #34495e;
            font-size: 15px;
            line-height: 1.7;
        }
        
        /* Course details */
        .details-container {
            background-color: #f8fafc;
            border: 1px solid #e3e8ee;
            border-radius: 6px;
            padding: 20px;
            margin-bottom: 30px;
        }
        
        .details-heading {
            font-size: 16px;
            font-weight: 700;
            color: #1e5799;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e3e8ee;
        }
        
        .detail-item {
            display: flex;
            margin-bottom: 12px;
        }
        
        .detail-item:last-child {
            margin-bottom: 0;
        }
        
        .detail-name {
            flex: 0 0 120px;
            font-weight: 600;
            color: #4a5568;
        }
        
        .detail-value {
            flex: 1;
            color: #2d3748;
        }
        
        /* Action button */
        .action-section {
            text-align: center;
            margin: 30px 0;
        }
        
        .action-link {
            display: inline-block;
            background: linear-gradient(to right, #1e5799, #207cca);
            color: white;
            text-decoration: none;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(30, 87, 153, 0.2);
        }
        
        .action-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 7px 14px rgba(30, 87, 153, 0.25);
        }
        
        /* Important notice */
        .important-notice {
            background-color: #fffbea;
            border-left: 4px solid #f6ad55;
            padding: 15px 20px;
            border-radius: 4px;
            font-size: 14px;
            color: #744210;
            margin-top: 25px;
        }
        
        .notice-title {
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        /* Footer */
        .notification-footer {
            background-color: #f8fafc;
            padding: 20px 30px;
            border-top: 1px solid #e3e8ee;
            text-align: center;
            font-size: 13px;
            color: #718096;
        }
        
        .footer-nav {
            margin-bottom: 15px;
        }
        
        .footer-link {
            color: #4299e1;
            text-decoration: none;
            margin: 0 10px;
            font-weight: 500;
        }
        
        .footer-link:hover {
            text-decoration: underline;
        }
        
        .footer-text {
            margin-bottom: 10px;
        }
        
        .copyright-text {
            font-size: 12px;
            color: #a0aec0;
        }
        
        /* Utility classes */
        .text-center {
            text-align: center;
        }
        
        .mb-10 {
            margin-bottom: 10px;
        }
        
        .mb-20 {
            margin-bottom: 20px;
        }
        
        /* Responsive styles */
        @media screen and (max-width: 600px) {
            body {
                padding: 10px;
            }
            
            .top-banner {
                padding: 20px;
            }
            
            .banner-icon {
                display: none;
            }
            
            .content-section {
                padding: 20px;
            }
            
            .detail-item {
                flex-direction: column;
            }
            
            .detail-name {
                margin-bottom: 5px;
            }
            
            .action-link {
                display: block;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="notification-wrapper">
        <div class="brand-header">
            <img src="{{ asset('student/images/logo.svg') }}" alt="LJKU Logo" class="brand-logo">
        </div>
        
        <div class="notification-card">
            <div class="top-banner">
                <h1 class="banner-title">Certificate Request Published</h1>
                <p class="banner-subtitle">A new certificate upload request requires your attention</p>
                <div class="banner-icon">📝</div>
            </div>
            
            <div class="content-section">
                <p class="salutation">Dear {{ $student->name }},</p>
                
                <p class="notification-text">
                    We are writing to inform you that a new certificate upload request has been published for your batch and department. This certificate is required as part of your academic records and to maintain compliance with university requirements.
                </p>
                
                <div class="details-container">
                    <h2 class="details-heading">Certificate Request Information</h2>
                    
                    <div class="detail-item">
                        <div class="detail-name">Course:</div>
                        <div class="detail-value">{{ $certificateRequest->course_name }}</div>
                    </div>
                    
                    <div class="detail-item">
                        <div class="detail-name">Department:</div>
                        <div class="detail-value">{{ $certificateRequest->department->name ?? 'All Departments' }}</div>
                    </div>
                    
                    <div class="detail-item">
                        <div class="detail-name">Batch:</div>
                        <div class="detail-value">{{ $certificateRequest->batch->start_year ?? 'All Batches' .  $certificateRequest->batch->end_year}}</div>
                    </div>
                </div>
                
                <div class="action-section">
                    <a href="{{ url('/student/certificate-requests') }}" class="action-link">
                        View & Upload Certificate
                    </a>
                </div>
                
                <div class="important-notice">
                    <div class="notice-title">Important Information</div>
                    <p>Please ensure that the certificate you upload is in PDF format and is clearly legible. Certificates will be verified by university staff before being accepted.</p>
                </div>
                
                <p class="notification-text mb-10">
                    Timely submission of your certificate is important. If you encounter any difficulties during the upload process, please contact the university administration office for assistance.
                </p>
                
                <p class="notification-text">
                    Thank you for your prompt attention to this matter.
                </p>
            </div>
            
            <div class="notification-footer">
                <div class="footer-nav">
                    <a href="{{ url('/') }}" class="footer-link">Website</a> | 
                    <a href="{{ url('/student/profile') }}" class="footer-link">Profile</a>
                </div>
                
                <p class="footer-text">
                    This is an automated message. Please do not reply directly to this email.
                </p>
                
                <p class="footer-text">
                    If you have any questions, please contact <a href="mailto:support@ljku.edu.in" class="footer-link">support@ljku.edu.in</a>
                </p>
                
                <p class="copyright-text">
                    &copy; {{ date('Y') }} LOK JAGRUTI KENDRA UNIVERSITY. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
