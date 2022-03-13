# quizgame
Party game based on RaspberryPi

General info:

•	Song-title-guessing party game, inspired by “Name that tune” TV show (or “Jaka to melodia” in my country).
•	After somebody hits a button, the music pauses and other buttons are blocked. First pressed button turns its LED on. Game host controls everything via web interface, sees correct answers and can pause/unpause songs as well. 
•	Both wired and wireless buttons can be used simultaneously, so 11 players can participate. 

Prerequisites and explanations:
-	one Raspberry Pi is needed (3B+ in my case, but not much of a difference)
-	one AVR (Atmega8 in my case) for each wireless button
-	one RFM75 module for each wireless button and one for Raspberry. Both RFM75 and Atmega work well on 2xAA battery.
-	To use USB sticks rather than upload mp3 files to RPi directly, use i.e. usbmount or anything that will mount the stick automatically
-	Configure Raspberry Pi to act as a WiFi accesspoint so you can use your smartphone to access the web interface
-	use standard 3,5mm audio jack external speaker. It’s possible to use Bluetooth for audio output but pairing devices isn’t too convenient. Especially during a party with friends.
-	wired buttons need 2 RaspberryPi GPIOs for each button (one for button, one for led). I recommend using transistor (i.e. BC547) and connecting LEDs to 5V, rather than powering from GPIOs directly.
-	The creator of libraries for RFM is Kamil Górski http://freakone.pl/ - I only updated his libraries for RFM70 and RFM73 to support RFM75 (just little differences mentioned in datasheets)
-	the dumbest part of the project is “communication” between php and python. Php runs and sudo-kills python processes. The only thing that needs to be sent between php and python is pausing and unpausing the music. Now it’s done by creating and deleting one ‘pause’ file. I’ll do something more sophisticated some day…



