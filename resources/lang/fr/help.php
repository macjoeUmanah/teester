<?php
return [
  // Group
  'move_to_group' => 'Déplacer vers le groupe sélectionné',
  'group_name' => 'Nom du groupe comme référence',

  // Lists
  'list_group' => 'La liste sera ajoutée au groupe sélectionné',
  'list_name' => 'Nom de la liste comme référence',
  'list_sending_server' => 'Lorsqu\'un contact est ajouté à la liste, il sera utilisé pour envoyer un courrier électronique (bienvenue, confirmation, désabonnement, etc.) à ce contact',
  'list_custom_fileds' => 'Lors de l\'ajout d\'un contact, vous pouvez ajouter des informations supplémentaires telles que Prénom, Nom, Pays, etc. à ce contact',
  'list_double_optin' => 'Si cette option est définie sur "Oui", un courrier électronique de confirmation sera envoyé à ce contact.',
  'list_welcome_email' => 'Si vous voulez envoyer un email de bienvenue à ce contact',
  'list_unsub_email' => 'Si vous voulez ou ne voulez pas envoyer l\'e-mail de désabonnement aux destinataires, votre préférence avec "Oui" ou "Non"',
  'list_notification' => 'Si cette option est définie sur "Activé", un courrier électronique sera envoyé à l\'adresse "Notification électronique".',
  'list_notification_email' => 'Adresse électronique qui recevra une notification lorsque le contact sera ajouté',
  'list_notification_criteria' => 'Les e-mails de notification seront reçus lorsque les critères suivants sont mis en correspondance',
  'list_split' => 'La liste serait divisée en plusieurs listes, en fonction du nombre donné',

  // Custom Fields
  'custom_field_name' => 'Nom du champ personnalisé comme référence',
  'custom_field_type' => 'Le champ personnalisé ressemblerait au type défini.. Le type peut être un champ de texte, un champ numérique, une zone de texte, un champ de date, des boutons radio, des cases à cocher et une liste déroulante.',
  'custom_field_required' => 'Si cette option est définie sur "Obligatoire", cette option doit être remplie / choisie lors de l\'ajout d\'un contact.',
  'custom_fields_lists' => 'Le champ personnalisé peut être assigné à des listes multipel',

  // contacts
  'contact_list' => 'Le contact sera ajouté à la liste sélectionnée',
  'contact_email' => 'adresse e-mail de contact',
  'contact_html' => 'Si HTML, le contact recevra le contenu "HTML" de la diffusion; Sinon, contenu "texte"',
  'contact_active' => 'Le contact sera considéré comme "actif" ou "inactif"',
  'contact_confirmed' => 'Le contact sera considéré comme "confirmé" ou "non confirmé"',
  'contact_verified' => 'Définissez-le comme "Vérifié" ou "Non vérifié" selon le statut de votre destinataire. Le contact "vérifié" ignorera les "vérificateurs d\'e-mails"',
  'contact_unsubscribed' => 'Le contact sera considéré comme "Abonné" ou "Désabonné"',
  'contact_import' => 'Le fichier doit être importé',
  'contact_list_import' => 'Les contacts seront importés dans la liste sélectionnée',
  'contact_duplicate_import' => 'Si "Ignorer", les contacts existants seront ignorés lors de l\'importation; Sinon, les contacts existants seront écrasés',
  'contact_suppressed_import' => 'Si "Non autorisé", alors l\'importation ignorera les e-mails qui appartiennent à la suppression; Sinon, les e-mails seront importés qui appartiennent même à la suppression.',
  'contact_html_import' => 'Si HTML, les contacts recevront le contenu "HTML" de la diffusion; Sinon, contenu "texte"',
  'contact_active_import' => 'Les contacts seront considérés comme "actifs" ou "inactifs"',
  'contact_confirmed_import' => 'Les contacts seront considérés comme "confirmés" ou "non confirmés"',
  'contact_unsubscribed_import' => 'Les contacts seront considérés comme "Souscrits" ou "Désabonnés"',


  // Broadcast
  'broadcast_group' => 'La diffusion sera ajoutée au groupe sélectionné',
  'broadcast_name' => 'Nom de l\'émission comme référence',
  'broadcast_email_subject' => 'Il sera affiché comme sujet de l\'email. Tous les "Shortcodes" peuvent être utilisés dans le sujet de l\'email',

  // Schedule
  'schedule_name' => 'Nom de l\'annexe comme référence',
  'schedule_broadcast' => 'La diffusion doit être envoyée',
  'schedule_lists' => 'La campagne sera envoyée aux contacts sélectionnés.',
  'schedule_sending_servers' => 'La campagne sera envoyée à l\'aide des serveurs d\'envoi sélectionnés.',
  'schedule_send' => 'La campagne sera envoyée maintenant (instantanée) ou plus tard.',
  'schedule_speed' => 'Gérer la vitesse d\'envoi d\'une campagne',

  // Drip
  'drip_status' => 'La campagne au goutte à goutte sera considérée comme "active" ou "inactive"',
  'drip_group' => 'Toutes les campagnes anti-goutte feront partie de ce groupe et seront utilisées lors de la planification d\'un goutte-à-goutte.',
  'drip_name' => 'Nom de la campagne au goutte-à-goutte comme référence',
  'drip_broadcast' => 'Diffusion qui sera envoyée au contact',
  'drip_send' => 'Si "Instant", un email sera envoyé au contact instantanément, sinon un email sera envoyé selon la durée définie',

  // Drip Schedule
  'drip_schedule_name' => 'Nom du programme d\'égouttage à titre de référence',
  'drip_schedule_group' => 'Groupe d\'un égouttement qui doit être programmé',
  'drip_schedule_lists' => 'Le goutte à goutte sera appliqué sur les listes sélectionnées',
  'drip_schedule_sending_server' => 'Il sera utilisé pour envoyer un courrier électronique lorsque les critères définis dans la liste de contrôle sont remplis.',
  'drip_schedule_send_to_existing' => 'Si cette option est définie sur "Oui", les e-mails seront envoyés à tous les contacts de la liste sélectionnée, même ajoutés avant la création du goutte à goutte. Et en cas de "non", les emails seront envoyés aux contacts qui ont été ajoutés après la création du goutte à goutte',

  // Spintag
  'spintag_name' => 'Nom du Spingtag comme référence',
  'spintag_values' => 'Différentes valeurs peuvent être assignées à un spintag qui sera automatiquement tourné lors de l\'envoi. Utilisez la touche "Entrée" pour différentes valeurs',

  // Segments
  'segment_name' => 'Nom du segment comme référence',
  'segment_lists' => 'Le segment sera appliqué aux listes sélectionnées',
  'segment_campaigns' => 'Le segment sera appliqué aux campagnes sélectionnées',
  'segment_action' => 'L\'action doit être appliquée sur les campagnes sélectionnées.',
  'segment_countries' => 'L\'action sera appliquée sur les pays sélectionnés',

  // Sending Domain
  'sending_domain_name' => 'Le domaine d’envoi sera utilisé dans «Adresse électronique» lors de l’ajout d’un serveur d’envoi. Un domaine d\'envoi vérifié augmentera considérablement le nombre de boîtes de réception',
  'sending_domain_signing' => 'La signature DKIM sera générée dans une chaîne de texte unique, la "valeur de hachage". Avant d’envoyer le courrier électronique, la valeur de hachage est cryptée avec une clé privée, la signature DKIM.',

  // Sending Server
  'sending_server_group' => 'Le serveur d\'envoi sera ajouté au groupe sélectionné',
  'sending_server_name' => 'Nom du serveur d\'envoi comme référence',
  'sending_server_type' => 'Type de serveur d\'envoi',
  'sending_server_from_name' => "Los correos electrónicos parecen enviarse desde este nombre cuando este servidor de envío específico se utiliza para la entrega. \nSpintags se pueden usar en From Name",
  'sending_server_from_email' => 'Il sera utilisé comme courrier électronique d\'expéditeur pour une émission, etc. Il ne doit contenir qu\'un nom tel que, john',
  'sending_server_reply_email' => 'Il sera utilisé comme réponse par courrier électronique à une émission, etc.',
  'sending_server_bounce' => 'En cas de rebond, le courrier sera envoyé à l\'adresse de rebond sélectionnée.',
  'sending_server_speed' => 'Gérer la vitesse d\'envoi d\'un serveur d\'envoi',

  // Bounces
  'bounce_email' => 'L\'email de rebond sera utilisé comme référence',
  'bounce_method' => 'Il sera utilisé pour lire les mails depuis une boite mail rebondie',
  'bounce_host' => 'Nom d\'hôte de boîte aux lettres Bounce',
  'bounce_username' => 'Nom d\'utilisateur de la boîte mail Bounce',
  'bounce_password' => 'Bounce mail mot de passe',
  'bounce_port' => 'Port de boîte aux lettres de rebond',
  'bounce_encryption' => 'Option de cryptage de boîte aux lettres Bounce',
  'bounce_cert' => 'Option de certificat de boîte aux lettres Bounce',
  'bounce_delete' => 'Si cette option est définie sur "Oui", un courrier électronique sera supprimé de la boîte d\'envoi après l\'envoi.',

  // FBL
  'fbl_email' => 'Courriel de boucle de rétroaction sera utilisé comme référence',
  'fbl_method' => 'Il sera utilisé pour lire les mails depuis une boite mail de Feedback Loop',
  'fbl_host' => 'Nom d\'hôte de la boîte aux lettres Loop',
  'fbl_username' => 'Nom d\'utilisateur de boîte aux lettres de boucle',
  'fbl_password' => 'Mot de passe de la boîte mail Loop',
  'fbl_port' => 'Port de boîte aux lettres de boucle de rétroaction',
  'fbl_encryption' => 'Option de cryptage de boîte aux lettres de boucle de rétroaction',
  'fbl_cert' => 'Option de certificat de boîte aux lettres de boucle de rétroaction',
  'fbl_delete' => 'Si cette option est définie sur "Oui", un courrier électronique sera supprimé de la boîte mail de la boucle de feedback après le traitement.',

  // Suppression
  'suppression_group' => 'La suppression sera ajoutée au groupe sélectionné',
  'suppression_option' => 'Soit ajouter manuellement des adresses e-mail ou importer un fichier',
  'suppression_emails' => 'Plusieurs e-mails peuvent être ajoutés en même temps avec comman separator ou un seul e-mail par ligne',
  'suppression_file' => 'Le fichier d\'importation doit contenir un email par ligne',

  // WebForm 
  'webform_name' => 'Nom du formulaire Web en tant que référence',
  'webform_duplicate' => 'Si "Ignorer", les contacts existants seront ignorés lors de l\'ajout d\'un contact via un formulaire Web; Sinon, le contact existant sera écrasé',
  'webform_list' => 'Le contact sera ajouté à la liste sélectionnée lorsqu\'il sera ajouté via un formulaire Web.',
  'webform_custom_fields' => 'Quels champs supplémentaires doivent être affichés pour un formulaire Web avec le champ d\'adresse électronique par défaut',

  // Settings
  'license_key' => 'Clé de licence d\'application',
  'app_url' => 'URL de l\'application',
  'app_name' => 'Nom de l\'application',
  'top_left_html' => 'Il sera affiché en haut à gauche de l\'application après la connexion.',
  'login_html' => 'Il sera affiché à la page de connexion à droite à propos des champs de connexion',
  'login_page_image' => 'Cette image sera affichée à droite sur la page de connexion',
  'settings_sending_server' => 'Les notifications d\'applications et le mot de passe oublié, tels que les emails, seront envoyés en utilisant ces paramètres de messagerie',
  'settings_tracking' => 'L\'application s\'ouvre et le suivi des clics sera géré à l\'aide de cette option',
  'api_active' => 'Cela activera la fonctionnalité API de l\'application',
  'mail_headers' => '<small>Tous les shortcodes peuvent être utilisés dans la valeur d\'en-tête de courrier personnalisé</small>',

  // Page
  'page_email_subject' => 'Il sera affiché comme sujet de l\'email. Tous les "Shortcodes" peuvent être utilisés dans le sujet de l\'email',

  // General
  'test_send_email' => 'Adresse e-mail du destinataire',
  'test_send_sending_server' => 'L\'email sera envoyé en utilisant le serveur d\'envoi sélectionné',

  // PowerMTA
  'pmta_server_name' => 'Name eines Servers als Referenz',
  'pmta_server_os' => 'Name des Betriebssystems, auf dem PowerMTA installiert ist',
  'pmta_server_ip' => 'Server IP, auf dem PowerMTA installiert ist',
  'pmta_server_port' => 'Server Port',
  'pmta_server_username' => 'Server-Benutzername',
  'pmta_server_password' => 'Server-Passwort',

  'pmta_smtp_host' => 'SMTP-Host des Servers',
  'pmta_smtp_port' => 'SMTP-Port',
  'smtp_encryption' => 'SMTP-Verschlüsselung',
  'pmta_path' => 'Pfad des installierten PowerMTA',
  'pmta_management_port' => 'PowerMTA-Server-Port für HTTP-Zugriff',
  'pmta_admin_ips' => 'Durch Komma (,) getrennte IP-Liste für Administratorzugriff',
  'pmta_log_file_path' => 'PowerMTA-Protokolldateipfad',
  'pmta_acct_file_path' => 'PowerMTA Accounting-Dateipfad',
  'pmta_diag_file_path' => 'PowerMTA diag Dateipfad',
  'pmta_spool_path' => 'PowerMTA-Spoolpfad',
  'pmta_dkim_path' => 'PowerMTA DKIM-Dateipfad',
  'pmta_vmta_prefix' => 'Virtuelles MTA-Präfix',
  'pmta_ips' => 'Liste der durch Komma getrennten IPs (,)',
  'pmta_domains' => 'Liste der durch Komma getrennten Domains (,)',
  'pmta_from_name' => 'Von der Namensanzeige als Absendername zu einer E-Mail',
  'pmta_from_email' => 'Es wird als Absender-E-Mail verwendets',
  'pmta_bounce_email' => 'Im Falle eines Bounce wird die E-Mail an diese Bounce-Adresse zurückgesendet',
  'pmta_reply_email' => 'Es wird als Antwort-E-Mail-Adresse verwendet.',

  'pmta_bounce_method' => 'Es wird als Methode zum Lesen der E-Mails aus einer Bounce-Mailbox verwendet',
  'pmta_bounce_host' => 'Hostname der Bounce-Mailbox',
  'pmta_bounce_port' => 'Bounce-Mailbox-Port',
  'pmta_bounce_username' => 'Bounce Mailbox Benutzername',
  'pmta_bounce_password' => 'Bounce Mailbox Passwort',
  'pmta_bounce_encryption' => 'Bounce-Mailbox-Verschlüsselungsoption',
  'pmta_bounce_validate_cert' => 'Option für Bounce-Postfachzertifikat',

  'client_lists' => 'Les listes ne seront utilisées que pour l\'envoi du message au client',
  'client_sending_servers' => 'Les serveurs d\'envoi seront utilisés pour envoyer un message uniquement au client',
  'no_of_recipients' => 'Nombre de destinataires, que le client sera autorisé à ajouter, -1 pour un nombre illimité',
  'no_of_sending_servers' => 'Nombre d\'envoi de serveurs, que le client pourra ajouter, -1 pour illimité',
  'package_name' => 'Nom du package comme référence',
  'package_description' => 'Description du package',

  'webhook_help_heading' => 'Traiter les rapports de livraison pour ',
  'webhook_help_mailgun' => "
    <ol>
      <li><a href='https://login.mailgun.com/login/' target='_blank'>S'identifier</a> à votre compte Mailgun</li>
      <li>Aller vers <b>Sendings >> Webhooks</b></li>
      <li>Sélectionnez le domaine correct dans Mailgun</li>
      <li>Copiez l'URL du Webhook et collez-le dans les événements Webhook que vous souhaitez traiter, par ex.<br>
      Permanent Failure, Temporary Failure, Spam Complaints, etc.</li>
    </ol>",

  'webhook_help_sendgrid' => "
    <ol>
      <li><a href='https://app.sendgrid.com/login/' target='_blank'>S'identifier</a> à votre compte SendGrid</li>
      <li>Aller vers <b>Settings >> Mail Settings</b></li>
      <li>Activez l'événement Webhook, sélectionnez toutes les actions et insérez l'URL du Webhook.</li>
    </ol>",

  'bulk_update_based_on' => 'Soit peut être global (s\'applique à toutes les listes), soit une seule liste',
  'bulk_update_option' => 'Ajoutez les e-mails manuellement ou importez directement pour mettre à jour les destinataires',
  'bulk_update_lists' => 'Les destinataires des listes sélectionnées seraient mis à jour',
  'bulk_update_emails' => 'Vous pouvez ajouter plusieurs e-mails séparés par une virgule ou une ligne dans cette zone de texte',
  'bulk_update_file' => 'Le fichier doit inclure un e-mail par ligne pour être mis à jour avec précision',
  'bulk_update_action' => 'L\'action serait effectuée auprès des destinataires',

  'verify_list' => 'La liste doit être vérifiée',
  'email_verifiers_type' => 'Méthode de vérification',
  'list_clean_options' => 'Sélectionnez vos options pour nettoyer la liste',
  'contact_bounced_import' => 'Si "Non autorisé", alors l\'importation ignorera les e-mails qui appartiennent au rebond; Sinon, les e-mails seront importés qui appartiennent même au rebond.',

  'bounced_recipients' => 'Le changement affectera tous les destinataires actuels et futurs',
  'spam_recipients' => 'Le changement affectera tous les destinataires actuels et futurs',
  'suppressed_recipients' => 'Le changement affectera tous les destinataires actuels et futurs',

  'max_upload_file_size' => 'Cela limitera la limite de téléchargement de la taille maximale des fichiers',
  'sending_server_tracking_domain' => 'Il sera utilisé pour suivre les activités de messagerie comme ouvrir, cliquer, etc. Il est recommandé d\'utiliser un domaine de suivi qui est vérifié dans MailCarry et de s\'assurer que le suivi est "Activé" dans "Paramètres"',

  'trigger_name' => 'Nom du déclencheur comme référence',
  'trigger_based_on' => 'Le déclencheur peut être exécuté sur la base de listes, de segments (critères), ou sur un',
  'trigger_lists' => 'Les destinataires de la ou des listes sélectionnées recevront la campagne lors d\'un appel de déclenchement',
  'trigger_based_on_list_action' => 'Si l\'action est "Seulement nouvellement ajouté", la campagne recevra les destinataires qui ont été ajoutés après la création du déclencheur et si l\'action est "Tous les ajouts précédents et nouvellement ajoutés", la campagne recevra tous les destinataires déjà présents dans la liste et sera ajouté plus tard lors de la création du goutte à goutte',
  'trigger_segment' => 'Les destinataires du segment sélectionné (critères) recevront la campagne lors d\'un appel de déclenchement',
  'trigger_based_on_segment_action' => 'Si l\'action est "Uniquement nouvellement ajouté", la campagne recevra les destinataires qui ont été ajoutés après la création du déclencheur et si l\'action est "Tous précédemment et nouvellement ajoutés", la campagne recevra tous les destinataires déjà présents dans la liste et sera ajouté plus tard lors de la création du goutte à goutte',
  'trigger_send_date_time' => 'Les destinataires commenceront à recevoir les e-mails à la date précise',
  'trigger_action' => 'Soit vous souhaitez envoyer "Campagne" ou "Start Drip" (série de la campagne créée via le module "Drip")',
  'trigger_broadcast' => 'Les destinataires recevront cette campagne lorsque le déclencheur sera appelé',
  'trigger_drip' =>  'Les destinataires recevront cette série de campagnes comme indiqué dans le module "Drip" lorsque le déclencheur sera appelé',
  'trigger_start' => 'Lorsque la campagne doit démarrer "Instantanément" ou après une période spécifique. Remarque: la date de création des destinataires sera prise en compte pour la période de déclenchement',
  'trigger_sending_servers' => 'Le serveur d\'envoi sélectionné est utilisé pour envoyer la campagne ou le goutte à goutte.S\'il y a beaucoup de serveurs d\'envoi sélectionnés, l\'un est choisi au hasard',

  'webhook_help_elastic_email' => "
    <ol>
      <li><a href='https://elasticemail.com/account' target='_blank'>S'identifier</a>à votre compte ElasticEmail</li>
      <li>Aller vers <b>Settings >> Notifications</b></li>
      <li>Ajouter un nouveau Webhook</li>
      <li>Copiez l'URL du Webhook et collez-la dans le 'Lien de notification'</li>
      <li>Vérifiez les options pour</li>
      <li>Cliquez sur Enregistrer</li>
    </ol>",

    'dkim_selector' => 'Utiliser le sélecteur DKIM personnalisé',
    'dmarc_selector' => 'Utiliser le sélecteur DMARC personnalisé',
    'tracking_selector' => 'Utiliser le sélecteur de suivi personnalisé',

    'webhook_help_elastic_email' => "
    <ol>
      <li><a href='https://elasticemail.com/account' target='_blank'>Login</a> to your ElasticEmail account</li>
      <li>Navigate to <b>Settings >> Notifications</b></li>
      <li>Add new Webhook</li>
      <li>Copy the 'Webhook URL' and paste to the 'Notification Link'</li>
      <li>Check options for 'Complaints, Bounce/Error'</li>
      <li>Click Save</li>
    </ol>",

    'dkim_selector' => 'Utiliser le sélecteur DKIM personnalisé',
    'dmarc_selector' => 'Utiliser le sélecteur DMARC personnalisé',
    'tracking_selector' => 'Utiliser le sélecteur de suivi personnalisé',

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

    'pmta_dkim_selector' => 'Utiliser le sélecteur DKIM personnalisé',
    'pmta_dmarc_selector' => 'Utiliser le sélecteur DMARC personnalisé',
    'pmta_tracking_selector' => 'Utiliser le sélecteur de suivi personnalisé',
    'bounce_pmta_file' => 'Si vous souhaitez traiter uniquement les rebonds à partir des fichiers journaux PowerMTA, "Sélectionnez" cette option',

    'webform_welcome_email' => 'Cet e-mail sera envoyé à l\'abonné sous la forme d\'un "e-mail de bienvenue"',
    'webform_thankyou_page' => 'Cette page sera affichée à l\'abonné sous la forme d\'une "Page de remerciement"',
    'webform_confirmation_email' => 'Cet e-mail sera envoyé à l\'abonné sous la forme d\'un «e-mail de confirmation»',
    'webform_confirmation_page' => 'Cette page sera affichée à l\'abonné en tant que "Page de confirmation"',
    'webform_confirmation_help' => "<strong> Remarque: </strong> La page / l'e-mail de confirmation fonctionnera pour les listes de double opt-in",
    'thankyou_page_option' => 'Si l\'option est définie sur "Page de remerciement définie par le système", l\'abonné accédera à la page de remerciement telle que définie dans MailCarry, et si l\'option est définie sur "URL de la page personnalisée", l\'abonné accédera à la page qui sera être défini dans le champ URL de la page ci-dessous',
    'confirmation_page_option' => 'Si l\'option est définie sur "Page de remerciement définie par le système", l\'abonné accédera à la page de confirmation telle que définie dans MailCarry, et si l\'option est définie comme "URL de la page personnalisée", l\'abonné accédera à la page qui sera être défini dans le champ URL de la page ci-dessous après confirmation',

    'trigger_run' => 'Quand le déclencheur commencera',
    'trigger_execute_date_time' => 'Quand le déclencheur commencera pour le traitement',

    'list_confirmation_email_id' => 'Si l\'option «Double Opt-In» est définie sur «Oui», le système envoie cet e-mail de confirmation aux destinataires suivant la procédure de double opt-in de l\'abonnement',
    'list_welcome_email_id' => 'Si «E-mail de bienvenue» est défini sur «Oui», le système envoie l\'e-mail de bienvenue aux destinataires',
    'list_unsub_email_id' => 'Si l\'option «E-mail de désabonnement» est définie sur «Oui», le système envoie l\'e-mail de désinscription aux destinataires',

    'login_background_color' => 'Couleur d\'arrière-plan de la page de connexion',
    'trigger_status' => 'Seul le déclencheur "Actif" est pris en compte pour l\'envoi, le déclencheur avec un statut "Inactif" sera ignoré',
];