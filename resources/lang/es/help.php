<?php
return [
  // Group
  'move_to_group' => 'Seleccione un grupo para mover listas a',
  'group_name' => 'Nombre del grupo para la referencia del sistema interno.',

  // Lists
  'list_group' => 'La lista se agregará bajo el grupo seleccionado',
  'list_name' => 'Nombre de la lista como referencia',
  'list_sending_server' => 'El servidor de envío seleccionado se utiliza para enviar notificaciones / correos electrónicos del sistema, como bienvenida, confirmación, cancelación de suscripción, etc. a los destinatarios que pertenecen a esta lista.',
  'list_custom_fileds' => 'Adjunte campos a esta lista para luego agregar información de contacto adicional en los campos seleccionados, p. Nombre, país, título y otra información del destinatario.',
  'list_double_optin' => 'Si la opción está configurada como "Sí", el sistema envía un correo electrónico de confirmación a los destinatarios siguiendo el procedimiento de suscripción doble.',
  'list_welcome_email' => 'Si desea o no desea enviar el correo electrónico de bienvenida a los destinatarios, su preferencia con "Sí" o "No"',
  'list_unsub_email' => 'Si desea o no desea enviar el correo electrónico de cancelación de suscripción a los destinatarios, su preferencia con "Sí" o "No"',
  'list_notification' => 'Si esta opción está configurada como "Activada", se enviará un correo electrónico a la dirección de "Correo electrónico de notificación"',
  'list_notification_email' => 'Cuando esté habilitado, las notificaciones se enviarán a la dirección de correo electrónico mencionada en este campo.',
  'list_notification_criteria' => 'El sistema genera y envía una notificación cuando se cumplen los criterios seleccionados',
  'list_split' => 'Divida la lista en la cantidad de listas que menciona en este campo vacío',

  // Custom Fields
  'custom_field_name' => 'Nombre del campo personalizado para referencia interna del sistema, p. Nombre, Título, etc.',
  'custom_field_type' => 'Qué tipo de campo se adapta al propósito de la información adicional que desea agregar con la entrada de los destinatarios, p. Ej. Campo de texto para el nombre o botones de radio para el campo de género género, etc.',
  'custom_field_required' => 'Si la opción se establece como "Obligatorio", hace que el campo personalizado específico sea obligatorio para seleccionar / completar con la información adecuada para guardar un registro de destinatarios en la lista.',
  'custom_fields_lists' => 'Se puede asignar un campo personalizado a varias listas marcando las casillas de verificación',

  // contacts
  'contact_list' => 'El destinatario se agregará a la selección seleccionada de las existentes aquí',
  'contact_email' => 'Dirección de correo electrónico de los destinatarios',
  'contact_html' => 'Configúrelo como HTML si desea que el destinatario reciba el contenido HTML junto con el texto. Seleccione "Texto" si solo los correos electrónicos de texto están destinados al destinatario.',
  'contact_active' => 'Los destinatarios configurados como "Inactivos" no podrán recibir campañas de correo electrónico. Configúrelos como "Activos" para seguir enviando correos electrónicos.',
  'contact_confirmed' => 'Configúrelo como "Confirmar" o "Sin confirmar" según el estado de su destinatario. Si se establece en "Confirmar", se enviará un correo electrónico al destinatario para solicitar la confirmación',
  'contact_verified' => 'Configúrelo como "Verificado" o "No verificado" según el estado de su destinatario. El contacto "verificado" se omitirá para "Verificadores de correo electrónico"',
  'contact_unsubscribed' => 'Si establece el estado del destinatario como "No suscrito", no se enviarán correos electrónicos futuros a dichos destinatarios en la lista específica. Establezca el estado como "Suscribirse" para seguir enviando correos electrónicos activamente',
  'contact_import' => 'Seleccione el archivo que necesita importarse',
  'contact_list_import' => 'La información de los destinatarios se importará y guardará en la lista seleccionada del menú desplegable.',
  'contact_duplicate_import' => 'Al seleccionar la opción como "Omitir", se omitirá la entrada duplicada durante la importación, y si se configura como "Sobrescribir", la entrada duplicada sobrescribirá el registro del destinatario guardado en la lista de destinos.',
  'contact_suppressed_import' => 'Si "No está permitido", la importación omitirá los correos electrónicos que pertenecen a la supresión; De lo contrario, se importarán los correos electrónicos que incluso pertenecen a la supresión.',
  'contact_html_import' => 'Configúrelo como HTML si desea que el destinatario reciba el contenido HTML junto con el texto. Seleccione "Texto" si solo los correos electrónicos de texto están destinados al destinatario.',
  'contact_active_import' => 'Los destinatarios configurados como "Inactivos" no podrán recibir campañas de correo electrónico. Configúrelos como "Activos" para seguir enviando correos electrónicos.',
  'contact_confirmed_import' => 'Configúrelo como "Confirmar" o "Sin confirmar" según el estado de su destinatario.',
  'contact_unsubscribed_import' => 'Si establece el estado del destinatario como "No suscrito", no se enviarán correos electrónicos futuros a dichos destinatarios en la lista específica. Establezca el estado como "Suscribirse" para seguir enviando correos electrónicos activamente',


  // Broadcast
  'broadcast_group' => 'La campaña se agregará al grupo seleccionado.',
  'broadcast_name' => 'Nombre de la campaña para mantener una referencia interna del sistema. Los destinatarios no podrán ver este nombre.',
  'broadcast_email_subject' => 'Este es el tema de su correo electrónico y puede usar todos los "códigos cortos" para que parezca más convincente.',

  // Campaign Schedule
  'schedule_name' => 'Una referencia para la cola de envío y puede ser cualquier cosa fácilmente identificable',
  'schedule_broadcast' => 'Seleccione una campaña que deba enviarse',
  'schedule_lists' => 'Los destinatarios de las listas seleccionadas recibirán la campaña.',
  'schedule_sending_servers' => 'Seleccione el servidor de envío para enviar los correos electrónicos de esta campaña.',
  'schedule_send' => 'Si desea comenzar a enviarlo "Ahora" o desea programarlo para la fecha y hora "Posterior". Selecciona la opción preferida.',
  'schedule_speed' => 'Gestiona la velocidad de envío de esta campaña. En el caso de "Ilimitado", el sistema intenta enviar todo lo que pueda en el menor tiempo posible, utilizando los recursos disponibles.',

  // Drip
  'drip_status' => 'Solo se consideran los envíos "activos" para el envío, se omitirán los que tengan un estado "inactivo".',
  'drip_group' => 'Seleccione un grupo para asignarle un correo electrónico por goteo. Más tarde, el grupo se selecciona para ejecutar la serie de goteo de acuerdo con el programa preestablecido',
  'drip_name' => 'Nombre de la campaña de goteo como referencia',
  'drip_broadcast' => 'Nombre del correo electrónico de goteo como referencia identificable dentro del sistema.',
  'drip_send' => 'El correo electrónico de goteo con una opción "Instantánea" seleccionada se envía de inmediato y el número de goteo "Después" X esperará a que se acerque el intervalo de tiempo.',

  // Drip Schedule
  'drip_schedule_name' => 'Una referencia de campaña de goteo para la cola de envío, p. Viaje del cliente',
  'drip_schedule_group' => 'Seleccione el grupo para comenzar a enviar las gotas en el horario preestablecido.',
  'drip_schedule_lists' => 'Los destinatarios de la (s) lista (s) seleccionada (s) recibirán las gotas.',
  'drip_schedule_sending_server' => 'Seleccione el servidor de envío mediante el cual el sistema enviará los correos electrónicos de goteo.',
  'drip_schedule_send_to_existing' => 'Al seleccionar la opción como “Sí”, se enviarán los correos electrónicos de goteo a todos los destinatarios de las listas seleccionadas, y al seleccionar la opción como “No” solo se enviarán goteos a los destinatarios agregados a las listas seleccionadas después del goteo. está siendo creado',

  // Spintag
  'spintag_name' => 'Dé un nombre a un nuevo Spintag como referencia.',
  'spintag_values' => 'Use diferentes valores sinónimos de una palabra o expresión para girar cuando se use dentro de un correo electrónico saliente, es decir, Hola, Hola, Hola. Presione "Enter" para anotar los valores separados por líneas en el cuadro de texto.',

  // Segments
  'segment_name' => 'Nombre del segmento como referencia',
  'segment_lists' => 'Seleccione la (s) lista (s) para aplicar criterios filtrados a los destinatarios de la lista seleccionada y separe los contactos que califican para los criterios.',
  'segment_campaigns' => 'Seleccione de la lista de campañas enviadas para aplicar los filtros y separar los destinatarios que califican para los criterios filtrados.',
  'segment_action' => 'Seleccione los criterios primarios preferidos para que los destinatarios califiquen para el segmento.',
  'segment_countries' => 'Reduzca aún más los criterios seleccionando los países que los destinatarios marcaron como abiertos para las campañas específicas seleccionadas',

  // Sending Domain
  'sending_domain_name' => 'El dominio de envío aparece con la "Dirección de correo electrónico de origen", es decir, juan@sendingdomain.com. Un dominio verificado mejora significativamente las posibilidades de llegar a la bandeja de entrada del destinatario.',
  'sending_domain_signing' => 'La firma DKIM se generará en una cadena de texto única, el "valor hash". Antes de enviar el correo electrónico, el valor hash se cifra con una clave privada, la firma DKIM',

  // Sending Server
  'sending_server_group' => 'Los servidores de envío forman parte de sus respectivos grupos, seleccione uno del menú desplegable o haga clic en + para agregar un nuevo grupo.',
  'sending_server_name' => 'Proporcione un nombre a esta entrada del servidor de envío para la referencia interna del sistema.',
  'sending_server_type' => 'Actualmente hay tres tipos principales de servidores, la función de correo PHP predeterminada, la función SMTP o una lista de servicios de envío / correo electrónico en la nube, p. Mailgun, Amazon y otros.',
  'sending_server_from_name' => "Los correos electrónicos parecen enviarse desde este nombre cuando este servidor de envío específico se utiliza para la entrega.\nSpintags se pueden usar en From Name",
  'sending_server_from_email' => 'Se utiliza como correo electrónico del remitente y debe crearse con uno de los dominios de remitente existentes en el sistema.',
  'sending_server_reply_email' => 'Las respuestas del lado del destinatario se reciben en esta dirección de correo electrónico.',
  'sending_server_bounce' => 'Seleccione el controlador de devolución para el servidor de envío específico, donde se reciben las notificaciones de devolución y luego el sistema accederá a las notificaciones a través de IMAP / POP para procesar correos electrónicos dentro de MailCarry.',
  'sending_server_speed' => 'Administre la velocidad de envío para el servidor de envío.',

  // Bounces
  'bounce_email' => 'El nombre de correo electrónico de devolución es necesario para que la referencia interna del sistema administre el controlador de devolución con este nombre.',
  'bounce_method' => 'Qué protocolo de acceso desea usar para acceder al buzón de devolución para leer los avisos de devolución y procesarlos más tarde en MailCarry?',
  'bounce_host' => 'Aloje en la bandeja de entrada del correo electrónico configurado para recibir los avisos de devolución',
  'bounce_username' => 'Nombre de usuario para acceder al buzón de devolución',
  'bounce_password' => 'Contraseña para autenticar el acceso para leer los avisos de devolución del buzón de devolución',
  'bounce_port' => 'Puerto de buzón de rebote, 110 y 143 son los puertos predeterminados respectivamente para POP e IMAP.',
  'bounce_encryption' => 'Opciones de cifrado para el buzón de rebote',
  'bounce_cert' => 'Opciones para validar el certificado seguro si es requerido por la conexión de buzón de rebote',
  'bounce_delete' => 'Si la opción está configurada como "Sí", los avisos por correo electrónico de los buzones devueltos se eliminarán automáticamente después de procesarse en MailCarry',

  // FBL
  'fbl_email' => 'Se requiere el nombre de correo electrónico FBL para que la referencia interna del sistema administre el procesador FBL con este nombre.',
  'fbl_method' => 'Qué protocolo de acceso desea utilizar para acceder al correo electrónico configurado para recibir los ISP que devuelven quejas de spam para procesarlas más adelante en MailCarry?',
  'fbl_host' => 'Aloje en la bandeja de entrada de correo electrónico configurada para recibir las ISP quejas devueltas',
  'fbl_username' => 'Nombre de usuario para acceder al buzón FBL',
  'fbl_password' => 'Contraseña para autenticar el acceso para leer los avisos de spam del buzón FBL',
  'fbl_port' => 'El puerto de buzón FBL, 110 y 143 son los puertos predeterminados respectivamente para POP e IMAP',
  'fbl_encryption' => 'Opciones de cifrado para el buzón FBL',
  'fbl_cert' => 'Opciones para validar el certificado seguro si es requerido por la conexión del buzón FBL',
  'fbl_delete' => 'Si la opción se establece como "Sí", los avisos por correo electrónico de los buzones de correo de FBL se eliminarán automáticamente después de ser procesados ​​dentro de MailCarry',

  // Suppression
  'suppression_group' => 'Los recursos suprimidos deben pertenecer a cierto grupo para una mejor categorización. Seleccione un grupo existente o cree uno haciendo clic en el signo +',
  'suppression_option' => 'Agregue los correos electrónicos manualmente o importe directamente a la lista de supresión',
  'suppression_emails' => 'Puede agregar varios correos electrónicos con comas o líneas separadas en este cuadro de texto',
  'suppression_file' => 'El archivo debe incluir un correo electrónico por línea para agregarlo con precisión a la lista de supresión',

  // WebForm 
  'webform_name' => 'Nombre del formulario web para la referencia del sistema interno',
  'webform_duplicate' => 'Si ya existe una entrada duplicada en la lista de destinos, se omite la que proviene del formulario web si selecciona la opción como "Omitir". La entrada duplicada en el archivo de destino se sobrescribirá con la nueva entrada proveniente del formulario web si la opción se selecciona como "Sobrescribir"',
  'webform_list' => 'El destinatario agregado a través del formulario web se guardará en la lista seleccionada.',
  'webform_custom_fields' => 'Qué campos adicionales desea mostrar junto con el correo electrónico para completar la información con el fin de suscribirse a la lista, p. Nombre, Género y tal?',

  // Settings
  'license_key' => 'Clave de licencia de la aplicación',
  'app_url' => 'URL de aplicación',
  'app_name' => 'Nombre de la aplicación, cambie si desea etiquetar la aplicación de forma privada.',
  'top_left_html' => 'Se mostrará en la esquina superior izquierda del tablero. Puede personalizar la etiqueta privada de la aplicación.',
  'login_html' => 'Pertenece al panel lateral izquierdo de su página de inicio de sesión',
  'login_page_image' => 'Explore y actualice la imagen en el panel derecho de la página de inicio de sesión',
  'settings_sending_server' => 'Configuraciones de correo para las notificaciones de la aplicación y olvida los correos electrónicos de tipo contraseña.',
  'settings_tracking' => 'El seguimiento de las aperturas y clics se controla globalmente aquí.',
  'api_active' => 'Habilitará las funciones de API para esta instalación.',
  'mail_headers' => '<small>(Todos los códigos cortos se pueden usar en el valor del encabezado de correo personalizado)</small>',

  // Page
  'page_email_subject' => 'Este es el tema de su notificación / correo electrónico y puede usar todos los "Códigos cortos" para que parezca más convincente.',

  // General
  'test_send_email' => 'Dirección de correo electrónico de los destinatarios',
  'test_send_sending_server' => 'El correo electrónico se enviará utilizando el servidor de envío seleccionado',

  // PowerMTA
  'pmta_server_name' => 'Nombre de un servidor para la referencia interna. Sin embargo, no está incluido en el archivo de configuración',
  'pmta_server_os' => 'Seleccione el nombre del sistema operativo donde está instalado PowerMTA',
  'pmta_server_ip' => 'IP del servidor donde está instalado PowerMTA',
  'pmta_server_port' => 'Puerto del servidor PowerMTA, el valor predeterminado es 25, pero debido a que el servidor entrante bloquea los 25 a veces, se utilizan puertos alternativos.',
  'pmta_server_username' => 'Nombre de usuario del servidor',
  'pmta_server_password' => 'Contraseña del servidor',

  'pmta_smtp_host' => 'Host SMTP del servidor',
  'pmta_smtp_port' => 'Puerto SMTP',
  'smtp_encryption' => 'Cifrado SMTP',
  'pmta_path' => 'Ruta de acceso de PowerMTA instalado',
  'pmta_management_port' => 'Puerto del servidor PowerMTA para acceso HTTP',
  'pmta_admin_ips' => 'Lista de ip separada por comas (,) para acceso de administrador',
  'pmta_log_file_path' => 'Ruta del archivo de registro de PowerMTA',
  'pmta_acct_file_path' => 'Ruta del archivo de contabilidad PowerMTA',
  'pmta_diag_file_path' => 'Ruta del archivo de diagnóstico de PowerMTA',
  'pmta_spool_path' => 'Ruta del carrete PowerMTA',
  'pmta_dkim_path' => 'Ruta de archivos DKIM de PowerMTA',
  'pmta_vmta_prefix' => 'Prefijo virtual de MTA',
  'pmta_ips' => 'Lista de IP separadas por coma (,)',
  'pmta_domains' => 'Lista de dominios separados por coma (,)',
  'pmta_from_name' => 'El destinatario de los correos electrónicos enviados desde este servidor verá esto como el nombre del remitente',
  'pmta_from_email' => 'Los correos electrónicos aparecerán enviados desde esta dirección de correo electrónico',
  'pmta_bounce_email' => 'La dirección de correo electrónico donde se recibirán los avisos de correos electrónicos devueltos',
  'pmta_reply_email' => 'Un correo electrónico donde se recibirán las respuestas del lado de los destinatarios.',

  'pmta_bounce_method' => 'Se utiliza como un método para leer los correos electrónicos de un buzón de rebote',
  'pmta_bounce_host' => 'Nombre de host del buzón de rebote',
  'pmta_bounce_port' => 'Puerto de buzón de rebote',
  'pmta_bounce_username' => 'Nombre de usuario de buzón de rebote',
  'pmta_bounce_password' => 'Contraseña de buzón de rebote',
  'pmta_bounce_encryption' => 'Opciones de cifrado de buzones de rebote',
  'pmta_bounce_validate_cert' => 'Opciones de certificado de seguridad de buzón de rebote',

  'client_lists' => 'Las listas se utilizarán para enviar propósitos solo al cliente',
  'client_sending_servers' => 'Los servidores de envío se utilizarán para enviar propósitos solo al cliente',
  'no_of_recipients' => 'No de destinatarios, que el cliente podrá agregar, -1 por tiempo ilimitado',
  'no_of_sending_servers' => 'No de servidores de envío, que el cliente podrá agregar, -1 por tiempo ilimitado',
  'package_name' => 'Nombre del paquete como referencia',
  'package_description' => 'Descripción del paquete.',

  'webhook_help_heading' => 'Procesar informes de entrega para ',
  'webhook_help_mailgun' => "
    <ol>
      <li><a href='https://login.mailgun.com/login/' target='_blank'>Iniciar sesión</a> a su cuenta de Mailgun</li>
      <li>Vete al <b>Sendings >> Webhooks</b></li>
      <li>Seleccione el dominio correcto dentro de Mailgun</li>
      <li>Copie la 'URL de Webhook' y péguela en los 'Eventos de Webhook' que desea procesar, p.<br>
      Permanent Failure, Temporary Failure, Spam Complaints, etc.</li>
    </ol>",

  'webhook_help_sendgrid' => "
    <ol>
      <li><a href='https://app.sendgrid.com/login/' target='_blank'>Iniciar sesión</a> a su cuenta SendGrid</li>
      <li>Navegar a <b>Settings >> Mail Settings</b></li>
      <li>Active Event Webhook, seleccione todas las acciones e inserte la 'URL de Webhook'</li>
    </ol>",

  'bulk_update_based_on' => 'Puede ser globalmente (aplicar a todas las listas) o una sola lista',
  'bulk_update_option' => 'Agregue los correos electrónicos manualmente o importe directamente para actualizar los destinatarios',
  'bulk_update_lists' => 'Los destinatarios de las listas seleccionadas se actualizarán.',
  'bulk_update_emails' => 'Puede agregar varios correos electrónicos con comas o líneas separadas en este cuadro de texto',
  'bulk_update_file' => 'El archivo debe incluir un correo electrónico por línea para ser actualizado con precisión',
  'bulk_update_action' => 'La acción se realizaría a los destinatarios.',

  'verify_list' => 'La lista necesita ser verificada',
  'email_verifiers_type' => 'Método de verificación',
  'list_clean_options' => 'Seleccione sus opciones para limpiar la lista',
  'contact_bounced_import' => 'Si está "No permitido", la importación omitirá los correos electrónicos que pertenecen a rebotados; De lo contrario, se importarán los correos electrónicos que incluso pertenecen al rebotado.',

  'bounced_recipients' => 'El cambio afectará a todos los destinatarios actuales y futuros',
  'spam_recipients' => 'El cambio afectará a todos los destinatarios actuales y futuros',
  'suppressed_recipients' => 'El cambio afectará a todos los destinatarios actuales y futuros',

  'max_upload_file_size' => 'Restringirá el límite máximo de carga de archivos',
  'sending_server_tracking_domain' => 'Se utilizará para rastrear actividades de correo electrónico como abrir, hacer clic, etc. Se recomienda usar un dominio de rastreo que esté verificado dentro de MailCarry y asegurarse de que el rastreo esté "Habilitado" en "Configuración".',

  'trigger_name' => 'Nombre del disparador como referencia',
  'trigger_based_on' => 'El disparador se puede ejecutar sobre la base de Listas, Segmento (criterios) o en un',
  'trigger_lists' => 'Los destinatarios de las listas seleccionadas recibirán la campaña cuando una llamada de activación',
  'trigger_based_on_list_action' => 'Si la acción es "Solo recién agregados", la campaña recibirá a los destinatarios que se agregaron después de que se creó el activador y si la acción es "Todos los agregados anteriormente y los recién agregados", la campaña recibirá a todos los destinatarios que ya existen en la lista. y se agregará más tarde cuando se cree el goteo',
  'trigger_segment' => 'Los destinatarios del segmento seleccionado (criterios) recibirán la campaña cuando una llamada de activación',
  'trigger_based_on_segment_action' => 'Si la acción es "Solo recién agregados", la campaña recibirá a los destinatarios que se agregaron después de que se creó el activador y si la acción es "Todos los agregados anteriormente y los nuevos", la campaña recibirá a todos los destinatarios que ya existen en la lista y se agregará más tarde cuando se cree el goteo',
  'trigger_send_date_time' => 'Los destinatarios comenzarán a recibir los correos electrónicos cuando ocurra la fecha específica',
  'trigger_action' => 'O desea enviar "Campaña" o "Iniciar goteo" (serie de la campaña que se creó a través del módulo "Goteo")',
  'trigger_broadcast' => 'Los destinatarios recibirán esta campaña cuando se llame al activador',
  'trigger_drip' =>  'Los destinatarios recibirán esta serie de campañas como se menciona en el módulo "Goteo" cuando se llame al activador.',
  'trigger_start' => 'Cuando la campaña debe comenzar de forma "instantánea" o después de un período de tiempo específico. Nota: La fecha de creación de los destinatarios se considerará para el período de tiempo de activación.',
  'trigger_sending_servers' => 'El servidor de envío seleccionado se utiliza para enviar la campaña o el goteo. Si se seleccionan muchos servidores de envío, se elige uno al azar.',

  'webhook_help_elastic_email' => "
    <ol>
      <li><a href='https://elasticemail.com/account' target='_blank'>Login</a> to your ElasticEmail account</li>
      <li>Navigate to <b>Settings >> Notifications</b></li>
      <li>Agregar nuevo webhook</li>
      <li>Copie la 'URL del webhook' y péguela en el 'Enlace de notificación'</li>
      <li>Ver opciones para 'Complaints, Bounce/Error'</li>
      <li>Clic en Guardar</li>
    </ol>",

    'dkim_selector' => 'Usar selector DKIM personalizado',
    'dmarc_selector' => 'Usar selector DMARC personalizado',
    'tracking_selector' => 'Usar selector de seguimiento personalizado',

    'webhook_help_elastic_email' => "
    <ol>
      <li><a href='https://elasticemail.com/account' target='_blank'>Login</a> to your ElasticEmail account</li>
      <li>Navigate to <b>Settings >> Notifications</b></li>
      <li>Add new Webhook</li>
      <li>Copy the 'Webhook URL' and paste to the 'Notification Link'</li>
      <li>Check options for 'Complaints, Bounce/Error'</li>
      <li>Click Save</li>
    </ol>",

    'dkim_selector' => 'Usar selector DKIM personalizado',
    'dmarc_selector' => 'Usar selector DMARC personalizado',
    'tracking_selector' => 'Usar selector de seguimiento personalizado',

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

    'schedule_speed' => 'Administre la velocidad de envío de este disparador. En el caso de "Ilimitado", el sistema intenta enviar todo lo que puede en el menor tiempo posible, utilizando los recursos disponibles.',

    'pmta_dkim_selector' => 'Usar selector DKIM personalizado',
    'pmta_dmarc_selector' => 'Usar selector DMARC personalizado',
    'pmta_tracking_selector' => 'Usar selector de seguimiento personalizado',
    'bounce_pmta_file' => 'Si desea procesar los rebotes de los archivos de registro de PowerMTA únicamente, "Seleccione" esta opción',

    'webform_welcome_email' => 'Este correo electrónico se enviará al suscriptor como un "Correo electrónico de bienvenida".',
    'webform_thankyou_page' => 'Esta página se mostrará al suscriptor como una "Página de agradecimiento"',
    'webform_confirmation_email' => 'Este correo electrónico se enviará al suscriptor como un "Correo electrónico de confirmación".',
    'webform_confirmation_page' => 'Esta página se mostrará al suscriptor como una "Página de confirmación"',
    'webform_confirmation_help' => "<strong> Nota: </strong> la página de confirmación / correo electrónico funcionará para las listas de suscripción doble",
    'thankyou_page_option' => 'Si la opción se establece como "Página de agradecimiento definida por el sistema", el suscriptor llegará a la página de agradecimiento tal como se define en MailCarry, y si la opción se establece como "URL de página personalizada", el suscriptor llegará a la página que definirse en el campo URL de la página siguiente',
    'confirmation_page_option' => 'Si la opción está configurada como "Página de agradecimiento definida por el sistema", el suscriptor llegará a la página de confirmación como se define en MailCarry, y si la opción está configurada como "URL de página personalizada", entonces el suscriptor llegará a la página que definirse en el campo URL de la página siguiente después de la confirmación',

    'trigger_run' => 'Cuando el gatillo comenzará',
    'trigger_execute_date_time' => 'Cuándo comenzará a procesarse el disparador',

    'list_confirmation_email_id' => 'Si la opción "Opt-In doble" está configurada como "Sí", el sistema envía este correo electrónico de confirmación a los destinatarios siguiendo el procedimiento de suscripción doble opt-in.',
    'list_welcome_email_id' => 'Si el "Correo electrónico de bienvenida" está configurado como "Sí", el sistema envía el correo electrónico de bienvenida a los destinatarios.',
    'list_unsub_email_id' => 'Si la opción "Cancelar suscripción por correo electrónico" está configurada como "Sí", el sistema envía el correo electrónico para cancelar la suscripción a los destinatarios.',

    'login_background_color' => 'Color de fondo de la página de inicio de sesión',
    'trigger_status' => 'Solo el disparador "Activo" se considera para el envío, el disparador con un estado "Inactivo" se omitirá',
];