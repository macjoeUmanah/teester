<?php
return [
  // Group
  'move_to_group' => 'Select a group to move lists to',
  'group_name' => 'Name of the group for the internal system reference',

  // Lists
  'list_group' => 'List will be added under the selected group',
  'list_name' => 'Name of the List as a reference',
  'list_sending_server' => 'The selected sending server is used to send notification/system emails such as welcome, confirmation, unsubscribe, etc. to the recipients belonging to this list.',
  'list_custom_fileds' => 'Attach fields to this list to later add additional contact information in the selected fields e.g. First Name, Country, Title and other information of the recipient.',
  'list_double_optin' => 'If the option is set as “Yes” system sends a confirmation email to the recipients following the double opt-in procedure of subscription.',
  'list_welcome_email' => 'If you want or don’t want to send the welcome email to the recipients, your preference with “Yes” or “No”',
  'list_unsub_email' => 'If you want or don’t want to send the unsubscribe email to the recipients, your preference with “Yes” or “No”',
  'list_notification' => 'If this option is set as "Enabled", then an email will be sent to "Notification Email" address',
  'list_notification_email' => 'When enabled, notifications will be sent to the email address mentioned in this field.',
  'list_notification_criteria' => 'System generates and send a notification when the selected criteria is met',
  'list_split' => 'Split the list into the number of list(s) you mention in this empty field',

  // Custom Fields
  'custom_field_name' => 'Name of the Custom Field for internal system reference e.g. First Name, Title, etc.',
  'custom_field_type' => 'What type of field suits the purpose of additional information you want to add with the recipients’ entry, e.g. Text Field for the First Name, or Radio Buttons for the gender Gender field, etc.',
  'custom_field_required' => 'If the option is set as “Required”,it makes the specific custom field mandatory to select/fill with appropriate information for saving a recipients record in the list.',
  'custom_fields_lists' => 'A custom field can be assigned to multiple list(s) by ticking the checkboxes

',

  // contacts
  'contact_list' => 'Recipient will be added to the select selected from the existing ones here',
  'contact_email' => 'Recipients email address',
  'contact_html' => 'Set it as HTML if you want the recipient to receive the HTML content along with the text. Select “Text” if only the text emails are intended for the recipient.',
  'contact_active' => 'Recipients set as "Inactive" will not be able to receive email campaigns. Set them as "Active" to keep sending emails.',
  'contact_confirmed' => 'Set it as "Confirm" or "Unconfirmed" as per the status of your recipient. If it will set to "Confirm" then an email will be sent to the recipient to ask about confirmation',
  'contact_verified' => 'Set it as "Verified" or "Unverified" as per the status of your recipient. "Verified" contact will be skip for "Email Verifiers"',
  'contact_unsubscribed' => 'If you set the status of recipient as "Unsubscribed", no future emails will be sent to such recipients in the specific list. Set the status as "Subscribe" to keep actively sending emails',
  'contact_import' => 'Select the file that needs to be imported',
  'contact_list_import' => 'Recipients information will be imported and saved to the list selected from the dropdown.',
  'contact_duplicate_import' => 'Selecting the option as "Skip" will skip the duplicate entry while importing, and if set as "Overwrite" then the duplicate entry overwrites the recipient record saved in the destination list.',
  'contact_suppressed_import' => 'If "Not allowed", then the import will skip the emails that belong to suppression; Otherwise, the emails will be importing that even belongs to the suppression.',
  'contact_html_import' => 'Set it as HTML if you want the recipient to receive the HTML content along with the text. Select “Text” if only the text emails are intended for the recipient.',
  'contact_active_import' => 'Recipients set as "Inactive" will not be able to receive email campaigns. Set them as "Active" to keep sending emails.',
  'contact_confirmed_import' => 'Set it as "Confirm" or "Unconfirmed" as per the status of your recipient.',
  'contact_unsubscribed_import' => 'If you set the status of recipient as "Unsubscribed", no future emails will be sent to such recipients in the specific list. Set the status as "Subscribe" to keep actively sending emails',


  // Broadcast
  'broadcast_group' => 'Campaign will be added under the selected group',
  'broadcast_name' => 'Name of the Campaign to keep an internal system reference. Recipients will not be able to see this name.',
  'broadcast_email_subject' => 'This is the subject of your email and you can use all "Shortcodes" to make it appear more convincing.',

  // Campaign Schedule
  'schedule_name' => 'A reference for the sending queue and it can be anything easily identifiable',
  'schedule_broadcast' => 'Select a campaign that needs to be sent',
  'schedule_lists' => 'The recipients of the selected list(s) will receive the campaign',
  'schedule_sending_servers' => 'Select the sending server to send the emails of this campaign',
  'schedule_send' => 'If you want to start sending it "Now" or want to schedule it for "Later" date and time. Select the preferred option.',
  'schedule_speed' => 'Manage the sending speed of this campaign. In case of "Unlimited", system attempts to send as much as it can in the short possible time span, utilizing the available resources.',

  // Drip
  'drip_status' => 'Only the "Active" drips are considered for sending, drips with an "Inactive" status will be skipped',
  'drip_group' => 'Select a group to assign a drip email to it. Later, the group is selected to execute the drip series according to the preset schedule',
  'drip_name' => 'Name of the Drip Campaign as a reference',
  'drip_broadcast' => 'Name of the drip email as an identifiable reference within the system.',
  'drip_send' => 'The drip email with an "Instant" option selected is sent immediately, and the drips "After" X number of time will wait for the time interval to approach.',

  // Drip Schedule
  'drip_schedule_name' => 'A reference of drip campaign for the sending queue, e.g. Customer Journey',
  'drip_schedule_group' => 'Select the group to start sending the drips at the preset schedule.',
  'drip_schedule_lists' => 'Recipients of the selected list(s) will receive the drips.',
  'drip_schedule_sending_server' => 'Select the sending server using which the system will send the drip emails.',
  'drip_schedule_send_to_existing' => 'Selecting the option as “Yes” will send the drip emails to all the recipients of the selected list(s), and selecting the option as “No” will only send drips to the recipients added to the selected list(s) after the drip is being created.',

  // Spintag
  'spintag_name' => 'Give a name to a new Spintag as a reference.',
  'spintag_values' => 'Use different synonymous values of a word or expression to spin when used within an out-going email, i.e. Hello, Hi, Hey. Press "Enter" to write down line separated values in the text box.',

  // Segments
  'segment_name' => 'Name of the Segment as a reference',
  'segment_lists' => 'Select the list(s) to apply filtered criteria to the recipients of the selected list and separate out contacts that qualify for the criteria.',
  'segment_campaigns' => 'Select from the list of sent campaigns to apply the filters and separate out recipients that qualify for the filtered criteria.',
  'segment_action' => 'Select the preferred primary criteria for the recipients to qualify for segment.',
  'segment_countries' => 'Narrow down the criteria further by selecting the countries the recipients marked as opened for the specific selected campaign(s)',

  // Sending Domain
  'sending_domain_name' => 'Sending domain appears with the “From Email Address” i.e. john@sendingdomain.com. A Verified domain significantly improves the chances of hitting the recipient’s inbox.',
  'sending_domain_signing' => 'The DKIM signature will be generated in a unique textual string, the ‘hash value’. Before the email is sent, the hash value is encrypted with a private key,the DKIM signature',

  // Sending Server
  'sending_server_group' => 'Sending Servers are made part of their respective groups, select one from the dropdown or click + to add a new group.',
  'sending_server_name' => 'Provide a name to this sending server entry for the internal system reference.',
  'sending_server_type' => 'There are currently three main types of servers, default PHP Mail function, SMTP functoin or a list of cloud email/sending services, e.g. Mailgun, Amazon and others.',
  'sending_server_from_name' => "The emails appear to be sent from this name when this specific sending server is used for delivery. \nSpintags can be used in From Name",
  'sending_server_from_email' => 'It is used as sender email and it has to be created with one of the existing sender domains you in the system.',
  'sending_server_reply_email' => 'The replies by the recipient side are received at this email address.',
  'sending_server_bounce' => 'Select the bounce handler for the specific sending server, where the bounce notices are received and then system will access the notices via IMAP/POP to process emails within MailCarry.',
  'sending_server_speed' => 'Manage the sending speed for the sending server.',

  // Bounces
  'bounce_email' => 'Bounce email name is required for the internal system reference to manage the bounce handler with this name.',
  'bounce_method' => 'Which access protocol you want to use to access the bounce mailbox to read the  bounce notices and process them later within MailCarry?',
  'bounce_host' => 'Host to the email inbox set to receive the bounce notices',
  'bounce_username' => 'Username to access the bounce mailbox',
  'bounce_password' => 'Password to authenticate access to read the bounce notices from the bounce mailbox',
  'bounce_port' => 'Bounce mailbox port, 110 and 143 are the default ports respectively for the POP and IMAP.',
  'bounce_encryption' => 'Encryption options for the bounce mailbox',
  'bounce_cert' => 'Options to validate the secuirty certificate if required by bounce mailbox connection',
  'bounce_delete' => 'If the option is set as "Yes", then the email notices from the bounce mailboxes will automatically be deleted after being processed within MailCarry',

  // FBL
  'fbl_email' => 'FBL email name is required for the internal system reference to manage the FBL processor with this name.',
  'fbl_method' => 'Which access protocol you want to use to access the email set to receive the ISPs returned spam complaints to process them later in the MailCarry?',
  'fbl_host' => 'Host to the email inbox set to receive the ISPs returned spam complaints',
  'fbl_username' => 'Username to access the FBL mailbox',
  'fbl_password' => 'Password to authenticate access to read the spam notices from the FBL mailbox',
  'fbl_port' => 'FBL mailbox port, 110 and 143 are the default ports respectively for the POP and IMAP',
  'fbl_encryption' => 'Encryption options for the FBL mailbox',
  'fbl_cert' => 'Options to validate the secuirty certificate if required by FBL mailbox connection',
  'fbl_delete' => 'If the option is set as "Yes", then the email notices from the FBL mailboxes will automatically be deleted after being processed within MailCarry',

  // Suppression
  'suppression_group' => 'Suppressed resources has to belong to a certain group for better categorization. Select an existing group or create one by cliking the + sign',
  'suppression_option' => 'Either add the emails manually or import directly to the suppression list',
  'suppression_emails' => 'You can add multiple emails comma or line separated in this textbox',
  'suppression_file' => 'The file must include one email per line to be accurately added to the suppression list',

  // WebForm 
  'webform_name' => 'Name of the Web Form for the internal system reference',
  'webform_duplicate' => 'If a duplicate entry exists in the destination list already, the one coming from the web form is skipped if you select the option as “Skip”. The duplicate entry in the destination file will be overwritten with the new entry coming from the web form if the option is selected as “Overwrite”',
  'webform_list' => 'Recipient added via web form will be saved in the selected list.',
  'webform_custom_fields' => 'Which additional fields you want to display along with the email to fill the information for the purpose of subscribe to the list, e.g. First Name, Gender and such?.',

  // Settings
  'license_key' => 'Application License Key',
  'app_url' => 'Application URL',
  'app_name' => 'Application Name, change if you want to private label the application.',
  'top_left_html' => 'It will be displayed on the top left corner of the dashboard. You can customize to private label the application.',
  'login_html' => 'It belongs to the left side pane of your login page',
  'login_page_image' => 'Browse and update the image on the right-side pane of the login page',
  'settings_sending_server' => 'Mail settings for the application notifications and forget password type emails.',
  'settings_tracking' => 'Tracking of the opens and clicks are globally controlled here.',
  'api_active' => 'It will enable the API features for this installation',
  'mail_headers' => '<small>(All shortcodes can be use in the custom mail header value)</small>',

  // Page
  'page_email_subject' => 'This is the subject of your notification/email and you can use all "Shortcodes" to make it appear more convincing.',

  // General
  'test_send_email' => 'Recipients email address',
  'test_send_sending_server' => 'Email will be sent using the selected sending server',

  // PowerMTA
  'pmta_server_name' => 'Name of a server for the internal reference. It is not included in the config file though',
  'pmta_server_os' => 'Select the name of the Operating System where PowerMTA is installed',
  'pmta_server_ip' => 'Server IP where PowerMTA is installed',
  'pmta_server_port' => 'PowerMTA server port, the default is 25 but due to the incoming server blocking the 25 sometimes, alternative ports are used.',
  'pmta_server_username' => 'Server Username',
  'pmta_server_password' => 'Server Password',

  'pmta_smtp_host' => 'SMTP host of the server',
  'pmta_smtp_port' => 'SMTP port',
  'smtp_encryption' => 'SMTP encryption',
  'pmta_path' => 'Path of installed PowerMTA',
  'pmta_management_port' => 'PowerMTA server port for HTTP access',
  'pmta_admin_ips' => 'Comma (,) separated ip list for admin access',
  'pmta_log_file_path' => 'PowerMTA log file path',
  'pmta_acct_file_path' => 'PowerMTA accounting file path',
  'pmta_diag_file_path' => 'PowerMTA diag file path',
  'pmta_spool_path' => 'PowerMTA spool path',
  'pmta_dkim_path' => 'PowerMTA DKIM files path',
  'pmta_vmta_prefix' => 'Virtual MTA prefix',
  'pmta_ips' => 'List of IPs separate by comma(,)',
  'pmta_domains' => 'List of Domains separate by comma(,)',
  'pmta_from_name' => 'The recipient of the emails sent from this server will see this as the sender name',
  'pmta_from_email' => 'Emails will appear to be sent from this email address',
  'pmta_bounce_email' => 'The email address where the notices of bounce emails will be received',
  'pmta_reply_email' => 'An email where the replies from the recipients side will be recieved.',

  'pmta_bounce_method' => 'It is used as a method to read the emails from a bounce mailbox',
  'pmta_bounce_host' => 'Bounce mailbox host name',
  'pmta_bounce_port' => 'Bounce mailbox port',
  'pmta_bounce_username' => 'Bounce mailbox username',
  'pmta_bounce_password' => 'Bounce mailbox password',
  'pmta_bounce_encryption' => 'Bounce mailbox encryption options',
  'pmta_bounce_validate_cert' => 'Bounce mailbox security certificate options',

  'client_lists' => 'Lists will be used for sending purpose only to the client',
  'client_sending_servers' => 'Sending Servers will be used for sending purpose only to the client',
  'no_of_recipients' => 'No of recipients, that the client will be allowed to add, -1 for unlimited',
  'no_of_sending_servers' => 'No of sending servers, that the client will be allowed to add, -1 for unlimited',
  'package_name' => 'Name of the Package as a reference',
  'package_description' => 'Description of the package',

  'webhook_help_heading' => 'Process Delivery Reports for ',
  'webhook_help_mailgun' => "
    <ol>
      <li><a href='https://login.mailgun.com/login/' target='_blank'>Login</a> to your Mailgun account</li>
      <li>Navigate to <b>Sendings >> Webhooks</b></li>
      <li>Select the correct domain within Mailgun</li>
      <li>Copy the 'Webhook URL' and paste to the 'Webhook Events' you want to process e.g.<br>
      Permanent Failure, Temporary Failure, Spam Complaints, etc.</li>
    </ol>",

  'webhook_help_sendgrid' => "
    <ol>
      <li><a href='https://app.sendgrid.com/login/' target='_blank'>Login</a> to your SendGrid account</li>
      <li>Navigate to <b>Settings >> Mail Settings</b></li>
      <li>Turn on Event Webhook, select all actions and insert the 'Webhook URL'</li>
    </ol>",

  'webhook_help_mailjet' => "
    <ol>
      <li><a href='https://app.mailjet.com/signin' target='_blank'>Login</a> to your Mailjet account</li>
      <li>Navigate to <b>Account Settings >> Event notifications (webhooks)</b></li>
      <li>Turn on Event Webhook, like Bounce, Spam, Blocked, etc. and insert the 'Webhook URL'</li>
    </ol>",

  'bulk_update_based_on' => 'Either can be globally (apply to all lists) or a single list',
  'bulk_update_option' => 'Either add the emails manually or import directly to update the recipients',
  'bulk_update_lists' => 'The recipients of the selected lists would be updated',
  'bulk_update_emails' => 'You can add multiple emails comma or line separated in this textbox',
  'bulk_update_file' => 'The file must include one email per line to be accurately updated',
  'bulk_update_action' => 'The action would be performed to the recipients',

  'verify_list' => 'The list needs to be verified',
  'email_verifiers_type' => 'Verification method',
  'list_clean_options' => 'Select your options to clean the list',
  'contact_bounced_import' => 'If "Not allowed", then the import will skip the emails that belong to bounced; Otherwise, the emails will be importing that even belongs to the bounced.',

  'bounced_recipients' => 'The change will affect all of the current and future coming recipients',
  'spam_recipients' => 'The change will affect all of the current and future coming recipients',
  'suppressed_recipients' => 'The change will affect all of the current and future coming recipients',

  'max_upload_file_size' => 'It will restrict the maximum file size upload limit',
  'sending_server_tracking_domain' => 'It will be used to track email activities like open, click, etc. It is recommended to use a tracking domain that is verified within MailCarry and make sure the tracking is "Enabled" in "Settings"',

  'trigger_name' => 'Name of the Trigger as a reference',
  'trigger_based_on' => 'The trigger can be executed on the bases of Lists, Segment(criteria), or on a specific',
  'trigger_lists' => 'The recipients of the selected list(s) will receive the campaign when a trigger call',
  'trigger_based_on_list_action' => 'If the action is "Only newly added" then the campaign will receive to those recipients that added after the trigger created and if the action is "All previously and newly added" then the campaign will receive to all of the recipients already exist in the list and will be added later when drip created',
  'trigger_segment' => 'The recipients of the selected segment(criteria) will receive the campaign when a trigger call',
  'trigger_based_on_segment_action' => 'If action is "Only newly added" then the campaign will receive to those recipients that added after the trigger created and if the action is "All previously and newly added" then the campaign will receive to all of the recipients already exist in the list and will be added later when drip created',
  'trigger_send_date_time' => 'Recipients will start to receive the emails when the specific date occurs',
  'trigger_action' => 'Either you want to send "Campaign" or "Start Drip"(series of the campaign that created via the "Drip" module)',
  'trigger_broadcast' => 'Recipients will be receiving this campaign when the trigger is called',
  'trigger_drip' =>  'Recipients will be receiving this series of campaigns as mentioned in the "Drip" module when the trigger is called',
  'trigger_start' => 'When Campaign needs to start either "Instant" or after a specific time period. Note: The recipients created date will be considered for the trigger time period',
  'trigger_sending_servers' => 'The selected sending server is used to send the campaign or drip, If there are many sending servers are selected then one is picked randomly',

  'webhook_help_elastic_email' => "
    <ol>
      <li><a href='https://elasticemail.com/account' target='_blank'>Login</a> to your ElasticEmail account</li>
      <li>Navigate to <b>Settings >> Notifications</b></li>
      <li>Add new Webhook</li>
      <li>Copy the 'Webhook URL' and paste to the 'Notification Link'</li>
      <li>Check options for 'Complaints, Bounce/Error'</li>
      <li>Click Save</li>
    </ol>",

    'dkim_selector' => 'Use custom DKIM selector',
    'dmarc_selector' => 'Use custom DMARC selector',
    'tracking_selector' => 'Use custom tracking selector',

    'webhook_help_amazon_ses' => "
    <b>Configure Amazon SES to send bounce/complaint information to Amazon SNS</b>
    <ol>
      <li><a href='https://console.aws.amazon.com/ses/' target='_blank'>Login</a> to Amazon SES console</li>
      <li>Click on <strong>Configuration Sets</strong></li>
      <li>Click on the <strong>'Create Configuration Set'</strong> button and define a name e.g <strong>MailCarry-Reports</strong>. (<strong>Note:</strong> This configuration set name will be used later within MailCarry)</li>
      <li>Click on the recently created Configuration Set</li>
      <li>In <strong>'Add Destination'</strong> and choose <strong>SNS</strong> from the dropdown</li>
      <li>Write a name e.g<strong> MailCarrySNS</strong> and select the event types you want to process. 
      <ul>
        <li>Reject</li>
        <li>Bounce</li>
        <li>Complaint</li>
        <li>Rendering Failure</li>
      </ul>
      </li>
      <li>From the Topic dropdown, select <strong>'Create SNS Topic'</strong></li>
      <li>Define a <strong>Topic Name</strong> e.g <strong>MailCarry-SNS-Topic</strong> and <strong>Display Name</strong></li>
      <li>Press <strong>Save</strong></li>
    </ol>
    <br>
    <b>Create a topic and subscription in Amazon SNS</b>
    <ol>
      <li>Now Navigate to <a href='https://console.aws.amazon.com/sns/v3' target='_blank'>Amazon Simple Notification Service (SNS)</a></li>
      <li><strong>Navigate</strong> to Topics</li>
      <li>Click on the <strong>recently created</strong> topic</li>
      <li>Click on <strong>'Create Subscription</strong> button</li>
      <li>Use the correct protocol i.e <strong>HTTP or HTTPS</strong></li>
      <li>For <b>Endpoint</b>, enter the <strong>'Webhook URL'</strong> [<strong>APP_URL]/callback/amazon</strong>] showing within MailCarry.</li>
      <li>Choose <b>Create subscription</b>.</li>
      <li>Select created subscription <b>eg. MailCarry-SNS</b> click <b>Request Confirmation</b></li>
      <li><b>Open</b> a file from <b> <a href='APP_URL/storage/amazonsns.txt' target='_blank'>APP_URL/storage/amazonsns.txt</a></b></li>
      <li><b>Copy</b> all contents from the file</li>
      <li><b>Paste</b> it to browser URL in new window, Once you see the confirmed message in <strong>XML format</strong>, it means the confirmation was successful!</li>
    </ol>

    <h5>You are all set now. Now copy the <strong>Configuration Set Name</strong> e.g <strong>MailCarry-Reports</strong> you created recently and
    paste it to <strong>Configuration Set Name</strong>.<h5>",

    'schedule_speed' => 'Manage the sending speed of this trigger. In case of "Unlimited", system attempts to send as much as it can in the short possible time span, utilizing the available resources.',

    'pmta_dkim_selector' => 'Use custom DKIM selector',
    'pmta_dmarc_selector' => 'Use custom DMARC selector',
    'pmta_tracking_selector' => 'Use custom Tracking selector',
    'bounce_pmta_file' => 'If you want to process the bounces from PowerMTA log files only, "Select" this option',

    'webform_welcome_email' => 'This email will be sent to the subscriber as a "Welcome Email"',
    'webform_thankyou_page' => 'This page will be displayed to the subscriber as a "Thankyou Page"',
    'webform_confirmation_email' => 'This email will be sent to the subscriber as a "Confirmation Email"',
    'webform_confirmation_page' => 'This page will be displayed to the subscriber as a "Confirmation Page"',
    'webform_confirmation_help' => "<strong>Note: </strong>The Confirmation Page/Email will be work for double opt-in Lists",
    'thankyou_page_option' => 'If the option is set as "System defined thankyou page" then the subscriber will be land on the thankyou page as defined in MailCarry, and if the option is set as "Custom page URL" then the subscriber will be land on the page that will be defined in the below Page URL field',
    'confirmation_page_option' => 'If the option is set as "System defined thankyou page" then the subscriber will be land on the confirmation page as defined in MailCarry, and if the option is set as "Custom page URL" then the subscriber will be land on the page that will be defined in the below Page URL field after confirmation',

    'trigger_run' => 'When the trigger will start',
    'trigger_execute_date_time' => 'When the trigger will start for processing',

    'list_confirmation_email_id' => 'If the option "Double Opt-In" is set as "Yes" the system sends this confirmation email to the recipients following the double opt-in procedure of subscription',
    'list_welcome_email_id' => 'If the "Welcome Email" is set as “Yes” the system sends the welcome email to the recipients',
    'list_unsub_email_id' => 'If the option "Unsubscribe Email" is set as “Yes” the system sends the unsubscribe email to the recipients',

    'login_background_color' => 'Login Page Background Color',
    'trigger_status' => 'Only the "Active" trigger are considered for sending, trigger with an "Inactive" status will be skipped',

];