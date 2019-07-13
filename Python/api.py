from O365 import Account, FileSystemTokenBackend
import datetime

def main():
    appid = ''
    appsecret = ''

    try:
        # authentication
        token = FileSystemTokenBackend(token_path='token', token_filename='o365_token.txt')
        account = Account((appid, appsecret), token_backend=token)
        account.connection.refresh_token()
        
        if not account.is_authenticated:
            account.authenticate(scopes=['basic', 'message_all'])

        # start download process
        save_attachment_to_folder(account)
    except Exception as msg:
        logger(msg)

def save_attachment_to_folder(account):
    # mailbox and folders
    mailbox = account.mailbox()
    outlook_folder = mailbox.get_folder(folder_id='')
    
    destination_folder = ''
    target_date = str(datetime.date.today() - datetime.timedelta(days = 1))
    file_names = []
    
    # loop messages from yesterday that haves attachments
    rule = (m for m in outlook_folder.get_messages(download_attachments=True) if str(m.received)[:10] == target_date)
    
    for message in rule:
        if message.has_attachments:
            for att in message.attachments:
                
                # get filename and save attachment to location
                if str(att).lower().endswith('.pdf'):
                    file_names.append(str(att)[11:])
                    att.save(destination_folder)
                    #print(att)
    
    # send notification email with filenames
    if len(file_names) > 1:
        send_mail(account, file_names, target_date)
        logger("Connected. Attachments found and downloaded.")
    else:
        logger("Connected. No mail with attachments.")

def send_mail(account, downloaded_filenames, target_date):
    # notificaton
    recipient_address = []
    
    subject = 'New attachements has been downloaded'
    message_text = 'Following ' + str(len(downloaded_filenames)) + ' files from ' + target_date +' has been downloaded to destination folder:<br><br>'
    message_list = ''

    # format filenames, ready for email
    for f in downloaded_filenames:
        message_list += '- ' + f + '<br>'
    
    # create and send message
    message = account.new_message()
    message.to.add(recipient_address)
    message.subject = subject
    message.body = message_text + message_list
    message.send()

def test_read_mail(account):
    mailbox = account.mailbox()
    folder = mailbox.get_folder(folder_id='')
    for message in folder.get_messages():
        print(message)

def logger(message): 
    # log message to file
    now = datetime.datetime.now()
    dt = now.strftime("%d/%m/%Y %H:%M:%S")
    f = open('o365graph.log', 'a+')
    f.write(dt + ' - ' + str(message) + '\n' + '---\n')
    f.close()

if __name__ == "__main__":
    main()