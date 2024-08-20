#!bin/bash
logs(){
	x=1
	while [ $x == 1 ]; do
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
				lasts $option
			;;
			2)
				clear
				cat "/var/run/utmp"	
			;;
			3)
				lasts $option
			;;
			4)
				clear
				cp "/var/log/messages" ~
			;;
			0)
				exit
			;;
		esac
	done
}
lasts(){
	i=$1
	if [ $i == 1 ]; then
		clear
		last -i
	elif [ $i == 2 ]; then
		clear
		lastb -i
	fi
}
logs
