import subprocess

services = [
    'client',
    'staff',
    'login',
    'order',
    'event'
]

for service in services:
    username = 'root'
    password = ''
    database = 'soa_' + service
    db_path = f'./{service}_service/{service}_sql/{database}.sql'
    print(database)
    print(db_path)
    # subprocess.call(['mysqldump', '--no-tablespaces', '-u', username, f'-p{password}', database, f'--result-file={db_path}'])

    # Define the full path to the mysqldump executable
    mysqldump_path = r'E:\xampp\mysql\bin\mysqldump.exe'
    
    # Define the command to export the database
    command = f'{mysqldump_path} -u {username} -p{password} --databases {database} > {db_path}'

    # Execute the command
    subprocess.run(command, shell=True)