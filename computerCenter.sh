#!bin/bash
x=1
services(){
	clear
	a=1
	while [ $a -eq 1 ]; do
		echo  "////////////////////////////////
1) apache2
2) mysql
3) ssh
0) exit
////////////////////////////////"
		read -p ": " option
		case $option in
			1)
				apache2
				;;
			2)
				mysql
				;;
			3)
				ssh
				;;
			0)
				a=0
				;;
		esac
	done 
}
apache2(){
	clear
	b=1
	while [ $b == 1 ]; do
		echo  "////////////////////////////////
1) Start apache2
2) Stop apache2
3) Restart apache2
4) Status apache2
0) Exit
////////////////////////////////"
		read -p ": " option
		case $option in
			1)
				clear
				sudo systemctl start apache2.service 
				;;
			2)
				clear
				sudo systemctl stop apache2.service &
				;;
			3)
				clear
				sudo systemctl restart apache2.service &
				;;
			4)
				clear
				sudo systemctl status apache2.service &
				;;
			0)
				b=0
				;;
		esac
	done
}

mysql(){
	clear
	b=1
	while [ $b == 1 ]; do
		echo  "////////////////////////////////
1) Start mysql-server
2) Stop mysql-server
3) Restart mysql-server
4) Status mysql-server 
0) Exit
////////////////////////////////"
		read -p ": " option
		case $option in
			1)
				clear
				sudo systemctl start mysql-server.service 
				;;
			2)
				clear
				sudo systemctl stop mysql-server.service &
				;;
			3)
				clear
				sudo systemctl restart mysql-server.service &
				;;
			4)
				clear
				sudo systemctl status mysql-server.service &
				;;
			0)
				b=0
				;;
		esac
	done
}

ssh(){
	clear
	b=1
	while [ $b == 1 ]; do
		echo  "////////////////////////////////
1) Start ssh
2) Stop ssh
3) Restart ssh
4) Status ssh 
0) Exit
////////////////////////////////"
		read -p ": " option
		case $option in
			1)
				clear
				sudo systemctl start sshd.service 
				;;
			2)
				clear
				sudo systemctl stop sshd.service &
				;;
			3)
				clear
				sudo systemctl restart sshd.service &
				;;
			4)
				clear
				sudo systemctl status sshd.service &
				;;
			0)
				b=0
				;;
		esac
	done
}
respaldos(){
	clear
	e=1
	while [ $e == 1 ]; do
		echo  "////////////////////////////////
1) Server Backup 
2) Web page Backup
3) DataBase Backup
4) Logs Backup
0) Exit
////////////////////////////////"
		read -p ": " option
		case $option in
			1)
				rsync -zvaP / user@192.168.122.53:path/to/backup
				;;
			2)
				rsync -bzavP /etc/httpd/www/dominioPagina/paginaProyecto user@192.168.122.53:/home/Backups/paginaProyecto
				;;
			3)
				mysqldump -u "user" -p "password" dataBase > /path/to/dumps/db.$(date).dump
				rsync -bzrvP /path/to/dumps/db.$(date).dump user@192.168.122.53:/home/Backups/dataBase
				;;
			4)
				rsync -bzrvP /path/to/logs user@192.168.122.53:/home/Backups/logs
				;;
			0)
				e=0
				;;
		esac
	done
}
usuarios(){
	clear
	c=1
	while [ $c == 1 ]; do
		echo  "////////////////////////////////
1) Create user 
2) Change user password
3) Look for a user
4) Delete a user
0) Exit
////////////////////////////////"
		read -p ": " option
		case $option in
			1)
				clear
				read -p "User name: " user
				sudo useradd $user
				;;
			2)
				clear
				read -p "User name: " user
				sudo passwd $user
				;;
			3)
				clear
				read -p "User name: " user
				sudo finger $user
				;;
			4) 
				clear
				read -p "User name: " user
				sudo userdel $user
				;;
			0)
				c=0
			;;
		esac
	done
}
logs(){
	clear
	d=1
	while [ $d == 1 ]; do
		echo "#######################################
1) Succesfull logins logs
2) Current logins 
3) Unsuccesfull logins logs
4) Copy complete logs
0) Exit
################################"
		read -p ": " option
		case $option in
			1)
				sudo last -i
				;;
			2)
				clear
				sudo last -p now
				;;
			3)
				sudo lastb -i 
				;;
			4)
				clear
				rsync -zvaP "/var/log/messages" ~
				;;
			0)
				d=0
				;;
		esac
	done
}

while [ $x == 1 ]; do
	clear
	echo "/////////////////////////////////
1) Servicios
2) Respaldos
3) Usuarios
4) Logs
0) exit
/////////////////////////////////"
	read -p ": " option
	case $option in
		1)
			services	
			;;
		2)
			respaldos
			;;
		3)
			usuarios
			;;
		4)
			logs
			;;
		0)
			x=0
			;;
	esac
done

