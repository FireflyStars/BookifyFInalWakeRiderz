<!--
|--------------------------------------------------------------------------
| BOOKING RECEIVED EMAIL
|--------------------------------------------------------------------------
|
| Available variables to be used
| $booking_id | $business_name | $category_photo | $primary_color | $secondary_color | $customer_first_name
| $customer_last_name | $booking_category | $booking_package | $booking_address | $booking_date | $booking_time
| $extra_services | $booking_invoice_amount | $booking_invoice_payment_method | $is_paid | $facebook_link |
| $twitter_link | $google_plus_link | $instagram_link | $pinterest_link
|
-->

<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <!-- NAME: ANNOUNCE -->
    <!--[if gte mso 15]>
    <xml>
        <o:OfficeDocumentSettings>
            <o:AllowPNG/>
            <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
    </xml>
    <![endif]-->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('emails.new_booking_title').' '.$booking_id }}</title>

    <style type="text/css">
        p{
            margin:10px 0;
            padding:0;
        }
        table{
            border-collapse:collapse;
        }
        h1,h2,h3,h4,h5,h6{
            display:block;
            margin:0;
            padding:0;
        }
        img,a img{
            border:0;
            height:auto;
            outline:none;
            text-decoration:none;
        }
        body,#bodyTable,#bodyCell{
            height:100%;
            margin:0;
            padding:0;
            width:100%;
        }
        .mcnPreviewText{
            display:none !important;
        }
        #outlook a{
            padding:0;
        }
        img{
            -ms-interpolation-mode:bicubic;
        }
        table{
            mso-table-lspace:0pt;
            mso-table-rspace:0pt;
        }
        .ReadMsgBody{
            width:100%;
        }
        .ExternalClass{
            width:100%;
        }
        p,a,li,td,blockquote{
            mso-line-height-rule:exactly;
        }
        a[href^=tel],a[href^=sms]{
            color:inherit;
            cursor:default;
            text-decoration:none;
        }
        p,a,li,td,body,table,blockquote{
            -ms-text-size-adjust:100%;
            -webkit-text-size-adjust:100%;
        }
        .ExternalClass,.ExternalClass p,.ExternalClass td,.ExternalClass div,.ExternalClass span,.ExternalClass font{
            line-height:100%;
        }
        a[x-apple-data-detectors]{
            color:inherit !important;
            text-decoration:none !important;
            font-size:inherit !important;
            font-family:inherit !important;
            font-weight:inherit !important;
            line-height:inherit !important;
        }
        .templateContainer{
            max-width:600px !important;
        }
        a.mcnButton{
            display:block;
        }
        .mcnImage,.mcnRetinaImage{
            vertical-align:bottom;
        }
        .mcnTextContent{
            word-break:break-word;
        }
        .mcnTextContent img{
            height:auto !important;
        }
        .mcnDividerBlock{
            table-layout:fixed !important;
        }
        /*
        @tab Page
//section Heading 1
	@style heading 1
	*/
        h1{
            /*@editable*/color:#000000;
            /*@editable*/font-family:'Roboto', 'Helvetica Neue', Helvetica, Arial, sans-serif;
            /*@editable*/font-size:40px;
            /*@editable*/font-style:normal;
            /*@editable*/font-weight:bold;
            /*@editable*/line-height:150%;
            /*@editable*/letter-spacing:normal;
            /*@editable*/text-align:center;
        }
        /*
        @tab Page
//section Heading 2
	@style heading 2
	*/
        h2{
            /*@editable*/color:#000000;
            /*@editable*/font-family:'Roboto', 'Helvetica Neue', Helvetica, Arial, sans-serif;
            /*@editable*/font-size:34px;
            /*@editable*/font-style:normal;
            /*@editable*/font-weight:bold;
            /*@editable*/line-height:150%;
            /*@editable*/letter-spacing:normal;
            /*@editable*/text-align:left;
        }
        /*
        @tab Page
//section Heading 3
	@style heading 3
	*/
        h3{
            /*@editable*/color:#000000;
            /*@editable*/font-family:'Roboto', 'Helvetica Neue', Helvetica, Arial, sans-serif;
            /*@editable*/font-size:22px;
            /*@editable*/font-style:normal;
            /*@editable*/font-weight:bold;
            /*@editable*/line-height:150%;
            /*@editable*/letter-spacing:normal;
            /*@editable*/text-align:left;
        }
        /*
        @tab Page
//section Heading 4
	@style heading 4
	*/
        h4{
            /*@editable*/color:#4e5e6a;
            /*@editable*/font-family:Georgia, Times, 'Times New Roman', serif;
            /*@editable*/font-size:20px;
            /*@editable*/font-style:italic;
            /*@editable*/font-weight:normal;
            /*@editable*/line-height:125%;
            /*@editable*/letter-spacing:normal;
            /*@editable*/text-align:center;
        }
        /*
        @tab Header
//section Header Container Style
	*/
        #templateHeader{
            /*@editable*/background-color:{{ $primary_color ? $primary_color : '#007bff' }};
            /*@editable*/background-image:none;
            /*@editable*/background-repeat:no-repeat;
            /*@editable*/background-position:center;
            /*@editable*/background-size:cover;
            /*@editable*/border-top:0;
            /*@editable*/border-bottom:0;
            /*@editable*/padding-top:11px;
            /*@editable*/padding-bottom:11px;
        }
        /*
        @tab Header
//section Header Interior Style
	*/
        .headerContainer{
            /*@editable*/background-color:#transparent;
            /*@editable*/background-image:none;
            /*@editable*/background-repeat:no-repeat;
            /*@editable*/background-position:center;
            /*@editable*/background-size:cover;
            /*@editable*/border-top:0;
            /*@editable*/border-bottom:0;
            /*@editable*/padding-top:0;
            /*@editable*/padding-bottom:0;
        }
        /*
        @tab Header
//section Header Text
	*/
        .headerContainer .mcnTextContent,.headerContainer .mcnTextContent p{
            /*@editable*/color:#ffffff;
            /*@editable*/font-family:'Roboto', 'Helvetica Neue', Helvetica, Arial, sans-serif;
            /*@editable*/font-size:16px;
            /*@editable*/line-height:150%;
            /*@editable*/text-align:left;
        }
        /*
        @tab Header
//section Header Link
	*/
        .headerContainer .mcnTextContent a,.headerContainer .mcnTextContent p a{
            /*@editable*/color:#ffffff;
            /*@editable*/font-weight:normal;
            /*@editable*/text-decoration:underline;
        }
        /*
        @tab Body
//section Body Container Style
	*/
        #templateBody{
            /*@editable*/background-color:#f1f1f1;
            /*@editable*/background-image:none;
            /*@editable*/background-repeat:no-repeat;
            /*@editable*/background-position:center;
            /*@editable*/background-size:cover;
            /*@editable*/border-top:0;
            /*@editable*/border-bottom:0;
            /*@editable*/padding-top:25px;
            /*@editable*/padding-bottom:25px;
        }
        /*
        @tab Body
//section Body Interior Style
	*/
        .bodyContainer{
            /*@editable*/background-color:#transparent;
            /*@editable*/background-image:none;
            /*@editable*/background-repeat:no-repeat;
            /*@editable*/background-position:center;
            /*@editable*/background-size:cover;
            /*@editable*/border-top:0;
            /*@editable*/border-bottom:0;
            /*@editable*/padding-top:0px;
            /*@editable*/padding-bottom:0px;
        }
        /*
        @tab Body
//section Body Text
	*/
        .bodyContainer .mcnTextContent,.bodyContainer .mcnTextContent p{
            /*@editable*/color:#000000;
            /*@editable*/font-family:'Roboto', 'Helvetica Neue', Helvetica, Arial, sans-serif;
            /*@editable*/font-size:16px;
            /*@editable*/line-height:150%;
            /*@editable*/text-align:left;
        }
        /*
        @tab Body
//section Body Link
	*/
        .bodyContainer .mcnTextContent a,.bodyContainer .mcnTextContent p a{
            /*@editable*/color:#007bff;
            /*@editable*/font-weight:normal;
            /*@editable*/text-decoration:underline;
        }
        /*
        @tab Footer
//section Footer Style
	*/
        #templateFooter{
            /*@editable*/background-color:{{ $secondary_color ? $secondary_color : '#4e5e6a' }};
            /*@editable*/background-image:none;
            /*@editable*/background-repeat:no-repeat;
            /*@editable*/background-position:center;
            /*@editable*/background-size:cover;
            /*@editable*/border-top:0;
            /*@editable*/border-bottom:0;
            /*@editable*/padding-top:15px;
            /*@editable*/padding-bottom:15px;
        }
        /*
        @tab Footer
//section Footer Interior Style
	*/
        .footerContainer{
            /*@editable*/background-color:#transparent;
            /*@editable*/background-image:none;
            /*@editable*/background-repeat:no-repeat;
            /*@editable*/background-position:center;
            /*@editable*/background-size:cover;
            /*@editable*/border-top:0;
            /*@editable*/border-bottom:0;
            /*@editable*/padding-top:0;
            /*@editable*/padding-bottom:0;
        }
        /*
        @tab Footer
//section Footer Text
	*/
        .footerContainer .mcnTextContent,.footerContainer .mcnTextContent p{
            /*@editable*/color:#FFFFFF;
            /*@editable*/font-family:'Roboto', 'Helvetica Neue', Helvetica, Arial, sans-serif;
            /*@editable*/font-size:12px;
            /*@editable*/line-height:150%;
            /*@editable*/text-align:center;
        }
        /*
        @tab Footer
//section Footer Link
	*/
        .footerContainer .mcnTextContent a,.footerContainer .mcnTextContent p a{
            /*@editable*/color:#FFFFFF;
            /*@editable*/font-weight:normal;
            /*@editable*/text-decoration:underline;
        }
        @media only screen and (min-width:768px){
            .templateContainer{
                width:600px !important;
            }

        }	@media only screen and (max-width: 480px){
            body,table,td,p,a,li,blockquote{
                -webkit-text-size-adjust:none !important;
            }

        }	@media only screen and (max-width: 480px){
            body{
                width:100% !important;
                min-width:100% !important;
            }

        }	@media only screen and (max-width: 480px){
            .mcnRetinaImage{
                max-width:100% !important;
            }

        }	@media only screen and (max-width: 480px){
            .mcnImage{
                width:100% !important;
            }

        }	@media only screen and (max-width: 480px){
            .mcnCartContainer,.mcnCaptionTopContent,.mcnRecContentContainer,.mcnCaptionBottomContent,.mcnTextContentContainer,.mcnBoxedTextContentContainer,.mcnImageGroupContentContainer,.mcnCaptionLeftTextContentContainer,.mcnCaptionRightTextContentContainer,.mcnCaptionLeftImageContentContainer,.mcnCaptionRightImageContentContainer,.mcnImageCardLeftTextContentContainer,.mcnImageCardRightTextContentContainer,.mcnImageCardLeftImageContentContainer,.mcnImageCardRightImageContentContainer{
                max-width:100% !important;
                width:100% !important;
            }

        }	@media only screen and (max-width: 480px){
            .mcnBoxedTextContentContainer{
                min-width:100% !important;
            }

        }	@media only screen and (max-width: 480px){
            .mcnImageGroupContent{
                padding:9px !important;
            }

        }	@media only screen and (max-width: 480px){
            .mcnCaptionLeftContentOuter .mcnTextContent,.mcnCaptionRightContentOuter .mcnTextContent{
                padding-top:9px !important;
            }

        }	@media only screen and (max-width: 480px){
            .mcnImageCardTopImageContent,.mcnCaptionBottomContent:last-child .mcnCaptionBottomImageContent,.mcnCaptionBlockInner .mcnCaptionTopContent:last-child .mcnTextContent{
                padding-top:18px !important;
            }

        }	@media only screen and (max-width: 480px){
            .mcnImageCardBottomImageContent{
                padding-bottom:9px !important;
            }

        }	@media only screen and (max-width: 480px){
            .mcnImageGroupBlockInner{
                padding-top:0 !important;
                padding-bottom:0 !important;
            }

        }	@media only screen and (max-width: 480px){
            .mcnImageGroupBlockOuter{
                padding-top:9px !important;
                padding-bottom:9px !important;
            }

        }	@media only screen and (max-width: 480px){
            .mcnTextContent,.mcnBoxedTextContentColumn{
                padding-right:18px !important;
                padding-left:18px !important;
            }

        }	@media only screen and (max-width: 480px){
            .mcnImageCardLeftImageContent,.mcnImageCardRightImageContent{
                padding-right:18px !important;
                padding-bottom:0 !important;
                padding-left:18px !important;
            }

        }	@media only screen and (max-width: 480px){
            .mcpreview-image-uploader{
                display:none !important;
                width:100% !important;
            }

        }	@media only screen and (max-width: 480px){
            /*
            @tab Mobile Styles
//section Heading 1
	@tip Make the first-level headings larger in size for better readability on small screens.
	*/
            h1{
                /*@editable*/font-size:30px !important;
                /*@editable*/line-height:125% !important;
            }

        }	@media only screen and (max-width: 480px){
            /*
            @tab Mobile Styles
//section Heading 2
	@tip Make the second-level headings larger in size for better readability on small screens.
	*/
            h2{
                /*@editable*/font-size:26px !important;
                /*@editable*/line-height:125% !important;
            }

        }	@media only screen and (max-width: 480px){
            /*
            @tab Mobile Styles
//section Heading 3
	@tip Make the third-level headings larger in size for better readability on small screens.
	*/
            h3{
                /*@editable*/font-size:20px !important;
                /*@editable*/line-height:150% !important;
            }

        }	@media only screen and (max-width: 480px){
            /*
            @tab Mobile Styles
//section Heading 4
	@tip Make the fourth-level headings larger in size for better readability on small screens.
	*/
            h4{
                /*@editable*/font-size:18px !important;
                /*@editable*/line-height:150% !important;
            }

        }	@media only screen and (max-width: 480px){
            /*
            @tab Mobile Styles
//section Boxed Text
	@tip Make the boxed text larger in size for better readability on small screens. We recommend a font size of at least 16px.
	*/
            .mcnBoxedTextContentContainer .mcnTextContent,.mcnBoxedTextContentContainer .mcnTextContent p{
                /*@editable*/font-size:14px !important;
                /*@editable*/line-height:150% !important;
            }

        }	@media only screen and (max-width: 480px){
            /*
            @tab Mobile Styles
//section Header Text
	@tip Make the header text larger in size for better readability on small screens.
	*/
            .headerContainer .mcnTextContent,.headerContainer .mcnTextContent p{
                /*@editable*/font-size:16px !important;
                /*@editable*/line-height:150% !important;
            }

        }	@media only screen and (max-width: 480px){
            /*
            @tab Mobile Styles
//section Body Text
	@tip Make the body text larger in size for better readability on small screens. We recommend a font size of at least 16px.
	*/
            .bodyContainer .mcnTextContent,.bodyContainer .mcnTextContent p{
                /*@editable*/font-size:16px !important;
                /*@editable*/line-height:150% !important;
            }

        }	@media only screen and (max-width: 480px){
            /*
            @tab Mobile Styles
//section Footer Text
	@tip Make the footer content text larger in size for better readability on small screens.
	*/
            .footerContainer .mcnTextContent,.footerContainer .mcnTextContent p{
                /*@editable*/font-size:14px !important;
                /*@editable*/line-height:150% !important;
            }

        }</style></head>
<body>

<center>
    <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
        <tr>
            <td align="center" valign="top" id="bodyCell">
                <!-- BEGIN TEMPLATE // -->
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td align="center" valign="top" id="templateHeader" data-template-container>
                            <!--[if (gte mso 9)|(IE)]>
                            <table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;">
                                <tr>
                                    <td align="center" valign="top" width="600" style="width:600px;">
                            <![endif]-->
                            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">
                                <tr>
                                    <td valign="top" class="headerContainer"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageBlock" style="min-width:100%;">
                                            <tbody class="mcnImageBlockOuter">
                                            <tr>
                                                <td valign="top" style="padding:0px" class="mcnImageBlockInner">
                                                    <table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" class="mcnImageContentContainer" style="min-width:100%;">
                                                        <tbody><tr>
                                                            <td class="mcnImageContent" valign="top" style="padding-right: 0px; padding-left: 0px; padding-top: 0; padding-bottom: 0;">


                                                                <img align="left" alt="{{ $business_name }}" src="{{ asset('images/logo-light.png') }}" width="250" style="max-width:500px; padding-bottom: 0; display: inline !important; vertical-align: bottom;" class="mcnRetinaImage">


                                                            </td>
                                                        </tr>
                                                        </tbody></table>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table></td>
                                </tr>
                            </table>
                            <!--[if (gte mso 9)|(IE)]>
                            </td>
                            </tr>
                            </table>
                            <![endif]-->
                        </td>
                    </tr>
                    <tr>
                        <td align="center" valign="top" id="templateBody" data-template-container>
                            <!--[if (gte mso 9)|(IE)]>
                            <table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;">
                                <tr>
                                    <td align="center" valign="top" width="600" style="width:600px;">
                            <![endif]-->
                            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">
                                <tr>
                                    <td valign="top" class="bodyContainer"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
                                            <tbody class="mcnTextBlockOuter">
                                            <tr>
                                                <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
                                                    <!--[if mso]>
                                                    <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
                                                        <tr>
                                                    <![endif]-->

                                                    <!--[if mso]>
                                                    <td valign="top" width="600" style="width:600px;">
                                                    <![endif]-->
                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                                                        <tbody><tr>

                                                            <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">

                                                                <p style="text-align: left;"><strong><span style="font-size:24px">{{ __('emails.greeting') }} {{ $customer_first_name }} {{ $customer_last_name }}!</span></strong><br>
                                                                    <br>
                                                                    {{ __('emails.booking_notice') }}</p>
                                                                @if(Session::has('password'))
                                                                    <br>
                                                                    <p>Please use {{ Session::get('password') }} and this email to login to your account. Its a temporary password so change it after first login.</p>
                                                                @endif

                                                            </td>
                                                        </tr>
                                                        </tbody></table>
                                                    <!--[if mso]>
                                                    </td>
                                                    <![endif]-->

                                                    <!--[if mso]>
                                                    </tr>
                                                    </table>
                                                    <![endif]-->
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock" style="min-width:100%;">
                                            <tbody class="mcnDividerBlockOuter">
                                            <tr>
                                                <td class="mcnDividerBlockInner" style="min-width: 100%; padding: 9px 18px;">
                                                    <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width: 100%;border-top: 1px solid #E0E0E0;">
                                                        <tbody><tr>
                                                            <td>
                                                                <span></span>
                                                            </td>
                                                        </tr>
                                                        </tbody></table>
                                                    <!--
                                                                    <td class="mcnDividerBlockInner" style="padding: 18px;">
                                                                    <hr class="mcnDividerContent" style="border-bottom-color:none; border-left-color:none; border-right-color:none; border-bottom-width:0; border-left-width:0; border-right-width:0; margin-top:0; margin-right:0; margin-bottom:0; margin-left:0;" />
                                                    -->
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
                                            <tbody class="mcnTextBlockOuter">
                                            <tr>
                                                <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
                                                    <!--[if mso]>
                                                    <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
                                                        <tr>
                                                    <![endif]-->

                                                    <!--[if mso]>
                                                    <td valign="top" width="600" style="width:600px;">
                                                    <![endif]-->
                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                                                        <tbody><tr>

                                                            <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">

                                                                <h3 style="text-align: left;"><span style="font-family:roboto,helvetica neue,helvetica,arial,sans-serif">{{ __('emails.booking_heading') }}</span></h3>
                                                                <br>
                                                                <h3>Notes:</h3>
                                                                <p>{!! config('settings.invoice_notes') !!}</p>
                                                                <h3>Terms & Conditions:</h3>
                                                                <p>{!! config('settings.invoice_terms') !!}</p>
                                                                <br>

                                                            </td>
                                                        </tr>
                                                        </tbody></table>
                                                    <!--[if mso]>
                                                    </td>
                                                    <![endif]-->

                                                    <!--[if mso]>
                                                    </tr>
                                                    </table>
                                                    <![endif]-->
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock" style="min-width:100%;">
                                            <tbody class="mcnDividerBlockOuter">
                                            <tr>
                                                <td class="mcnDividerBlockInner" style="min-width: 100%; padding: 18px 18px 0px;">
                                                    <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;">
                                                        <tbody><tr>
                                                            <td>
                                                                <span></span>
                                                            </td>
                                                        </tr>
                                                        </tbody></table>
                                                    <!--
                                                                    <td class="mcnDividerBlockInner" style="padding: 18px;">
                                                                    <hr class="mcnDividerContent" style="border-bottom-color:none; border-left-color:none; border-right-color:none; border-bottom-width:0; border-left-width:0; border-right-width:0; margin-top:0; margin-right:0; margin-bottom:0; margin-left:0;" />
                                                    -->
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnCaptionBlock">
                                            <tbody class="mcnCaptionBlockOuter">
                                            <tr>
                                                <td class="mcnCaptionBlockInner" valign="top" style="padding:9px;">




                                                    <table border="0" cellpadding="0" cellspacing="0" class="mcnCaptionRightContentOuter" width="100%">
                                                        <tbody><tr>
                                                            <td valign="top" class="mcnCaptionRightContentInner" style="padding:0 9px ;">
                                                                <table align="left" border="0" cellpadding="0" cellspacing="0" class="mcnCaptionRightImageContentContainer" width="264">
                                                                    <tbody><tr>
                                                                        <td class="mcnCaptionRightImageContent" align="left" valign="top">



                                                                            <img alt="{{ $booking_category }}" src="{{ asset($category_photo) }}" width="264" style="max-width:300px;" class="mcnImage">



                                                                        </td>
                                                                    </tr>
                                                                    </tbody></table>
                                                                <table class="mcnCaptionRightTextContentContainer" align="right" border="0" cellpadding="0" cellspacing="0" width="264">
                                                                    <tbody><tr>
                                                                        <td valign="top" class="mcnTextContent">
                                                                            <span style="font-size:22px"><span style="color:#077bff"><strong>{{ $booking_category }} </strong></span><span style="color:#000000"><strong>-</strong></span><span style="color:#077bff"><strong>&nbsp;</strong></span></span><strong><span style="font-size:19px"><span style="font-family:georgia,times,times new roman,serif">{{ $booking_package }}</span></span></strong><br>
                                                                            <br>
                                                                            {{ $booking_address }}<br>
                                                                            <strong>{{ $booking_date }} - {{ $booking_time }}<br>
                                                                                <br>
                                                                                <span style="font-size:18px">{{ __('emails.extra_services') }}</span></strong><br>
                                                                                {!! $extra_services !!}
                                                                            <strong>
                                                                                @if($is_paid)
                                                                                    {{ __('emails.total_paid') }} - {{ $booking_invoice_amount }} {{ __('emails.via') }} {{ $booking_invoice_payment_method }}
                                                                                @else
                                                                                    {{ __('emails.to_be_paid') }} - {{ $booking_invoice_amount }}
                                                                                @endif
                                                                            </strong>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody></table>
                                                            </td>
                                                        </tr>
                                                        </tbody></table>




                                                </td>
                                            </tr>
                                            </tbody>
                                        </table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock" style="min-width:100%;">
                                            <tbody class="mcnDividerBlockOuter">
                                            <tr>
                                                <td class="mcnDividerBlockInner" style="min-width: 100%; padding: 18px 18px 32px;">
                                                    <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width: 100%;border-top: 2px solid #EAEAEA;">
                                                        <tbody><tr>
                                                            <td>
                                                                <span></span>
                                                            </td>
                                                        </tr>
                                                        </tbody></table>
                                                    <!--
                                                                    <td class="mcnDividerBlockInner" style="padding: 18px;">
                                                                    <hr class="mcnDividerContent" style="border-bottom-color:none; border-left-color:none; border-right-color:none; border-bottom-width:0; border-left-width:0; border-right-width:0; margin-top:0; margin-right:0; margin-bottom:0; margin-left:0;" />
                                                    -->
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnButtonBlock" style="min-width:100%;">
                                            <tbody class="mcnButtonBlockOuter">
                                            <tr>
                                                <td style="padding-top:0; padding-right:18px; padding-bottom:18px; padding-left:18px;" valign="top" align="center" class="mcnButtonBlockInner">
                                                    <table border="0" cellpadding="0" cellspacing="0" class="mcnButtonContentContainer" style="border-collapse: separate !important;border-radius: 3px;background-color: #007BFF;">
                                                        <tbody>
                                                        <tr>
                                                            <td align="center" valign="middle" class="mcnButtonContent" style="font-family: Roboto, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-size: 18px; padding: 18px;">
                                                                <a class="mcnButton " title="Login To My Account" href="{{ route('login') }}" target="_self" style="font-weight: bold;letter-spacing: -0.5px;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">{{ __('emails.login_btn') }}</a>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table></td>
                                </tr>
                            </table>
                            <!--[if (gte mso 9)|(IE)]>
                            </td>
                            </tr>
                            </table>
                            <![endif]-->
                        </td>
                    </tr>
                    <tr>
                        <td align="center" valign="top" id="templateFooter" data-template-container>
                            <!--[if (gte mso 9)|(IE)]>
                            <table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;">
                                <tr>
                                    <td align="center" valign="top" width="600" style="width:600px;">
                            <![endif]-->
                            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">
                                <tr>
                                    <td valign="top" class="footerContainer"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowBlock" style="min-width:100%;">
                                            <tbody class="mcnFollowBlockOuter">
                                            <tr>
                                                <td align="center" valign="top" style="padding:9px" class="mcnFollowBlockInner">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentContainer" style="min-width:100%;">
                                                        <tbody><tr>
                                                            <td align="center" style="padding-left:9px;padding-right:9px;">
                                                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;" class="mcnFollowContent">
                                                                    <tbody><tr>
                                                                        <td align="center" valign="top" style="padding-top:9px; padding-right:9px; padding-left:9px;">
                                                                            <table align="center" border="0" cellpadding="0" cellspacing="0">
                                                                                <tbody><tr>
                                                                                    <td align="center" valign="top">
                                                                                        <!--[if mso]>
                                                                                        <table align="center" border="0" cellspacing="0" cellpadding="0">
                                                                                            <tr>
                                                                                        <![endif]-->

                                                                                        <!--[if mso]>
                                                                                        <td align="center" valign="top">
                                                                                        <![endif]-->

                                                                                        @if($facebook_link != NULL)<table align="left" border="0" cellpadding="0" cellspacing="0" class="mcnFollowStacked" style="display:inline;">
                                                                                                <tbody><tr>
                                                                                                    <td align="center" valign="top" class="mcnFollowIconContent" style="padding-right:10px; padding-bottom:9px;">
                                                                                                        <a href="{{ $facebook_link }}" target="_blank"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/color-facebook-96.png" alt="Facebook" class="mcnFollowBlockIcon" width="48" style="width:48px; max-width:48px; display:block;"></a>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                </tbody>
                                                                                            </table>@endif


                                                                                        <!--[if mso]>
                                                                                        </td>
                                                                                        <![endif]-->

                                                                                        <!--[if mso]>
                                                                                        <td align="center" valign="top">
                                                                                        <![endif]-->

                                                                                        @if($twitter_link != NULL)<table align="left" border="0" cellpadding="0" cellspacing="0" class="mcnFollowStacked" style="display:inline;">
                                                                                                <tbody><tr>
                                                                                                    <td align="center" valign="top" class="mcnFollowIconContent" style="padding-right:10px; padding-bottom:9px;">
                                                                                                        <a href="{{ $twitter_link }}" target="_blank"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/color-twitter-96.png" alt="Twitter" class="mcnFollowBlockIcon" width="48" style="width:48px; max-width:48px; display:block;"></a>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                </tbody>
                                                                                            </table>@endif

                                                                                        <!--[if mso]>
                                                                                        </td>
                                                                                        <![endif]-->

                                                                                        <!--[if mso]>
                                                                                        <td align="center" valign="top">
                                                                                        <![endif]-->


                                                                                        @if($instagram_link!=NULL)<table align="left" border="0" cellpadding="0" cellspacing="0" class="mcnFollowStacked" style="display:inline;">
                                                                                            <tbody><tr>
                                                                                                <td align="center" valign="top" class="mcnFollowIconContent" style="padding-right:10px; padding-bottom:9px;">
                                                                                                    <a href="{{ $instagram_link }}" target="_blank"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/color-instagram-96.png" alt="Link" class="mcnFollowBlockIcon" width="48" style="width:48px; max-width:48px; display:block;"></a>
                                                                                                </td>
                                                                                            </tr>
                                                                                            </tbody>
                                                                                        </table>@endif


                                                                                        <!--[if mso]>
                                                                                        </td>
                                                                                        <![endif]-->

                                                                                        <!--[if mso]>
                                                                                        <td align="center" valign="top">
                                                                                        <![endif]-->


                                                                                        @if($google_plus_link!=NULL)<table align="left" border="0" cellpadding="0" cellspacing="0" class="mcnFollowStacked" style="display:inline;">
                                                                                            <tbody><tr>
                                                                                                <td align="center" valign="top" class="mcnFollowIconContent" style="padding-right:10px; padding-bottom:9px;">
                                                                                                    <a href="{{ $google_plus_link }}" target="_blank"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/color-googleplus-96.png" alt="Google Plus" class="mcnFollowBlockIcon" width="48" style="width:48px; max-width:48px; display:block;"></a>
                                                                                                </td>
                                                                                            </tr>
                                                                                            </tbody>
                                                                                        </table>@endif


                                                                                        <!--[if mso]>
                                                                                        </td>
                                                                                        <![endif]-->

                                                                                        <!--[if mso]>
                                                                                        <td align="center" valign="top">
                                                                                        <![endif]-->

                                                                                        @if($pinterest_link!=NULL)<table align="left" border="0" cellpadding="0" cellspacing="0" class="mcnFollowStacked" style="display:inline;">
                                                                                            <tbody><tr>
                                                                                                <td align="center" valign="top" class="mcnFollowIconContent" style="padding-right:0; padding-bottom:9px;">
                                                                                                    <a href="{{ $pinterest_link }}" target="_blank"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/color-pinterest-96.png" alt="Pinterest" class="mcnFollowBlockIcon" width="48" style="width:48px; max-width:48px; display:block;"></a>
                                                                                                </td>
                                                                                            </tr>
                                                                                            </tbody>
                                                                                        </table>@endif


                                                                                        <!--[if mso]>
                                                                                        </td>
                                                                                        <![endif]-->

                                                                                        <!--[if mso]>
                                                                                        </tr>
                                                                                        </table>
                                                                                        <![endif]-->
                                                                                    </td>
                                                                                </tr>
                                                                                </tbody></table>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody></table>
                                                            </td>
                                                        </tr>
                                                        </tbody></table>

                                                </td>
                                            </tr>
                                            </tbody>
                                        </table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
                                            <tbody class="mcnTextBlockOuter">
                                            <tr>
                                                <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
                                                    <!--[if mso]>
                                                    <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
                                                        <tr>
                                                    <![endif]-->

                                                    <!--[if mso]>
                                                    <td valign="top" width="600" style="width:600px;">
                                                    <![endif]-->
                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                                                        <tbody><tr>

                                                            <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">

                                                                {{ __('emails.spam_notice') }}<br>
                                                                <br>
                                                                <em>{{ __('auth.copyrights') }}. &copy; {{ date('Y') }}. {{ __('auth.rights_reserved') }} {{ config('settings.business_name', 'Bookify') }}.</em>
                                                            </td>
                                                        </tr>
                                                        </tbody></table>
                                                    <!--[if mso]>
                                                    </td>
                                                    <![endif]-->

                                                    <!--[if mso]>
                                                    </tr>
                                                    </table>
                                                    <![endif]-->
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table></td>
                                </tr>
                            </table>
                            <!--[if (gte mso 9)|(IE)]>
                            </td>
                            </tr>
                            </table>
                            <![endif]-->
                        </td>
                    </tr>
                </table>
                <!-- // END TEMPLATE -->
            </td>
        </tr>
    </table>
</center>
</body>
</html>
