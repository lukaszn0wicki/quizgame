import wired
import RPi.GPIO as GPIO
import wireless
from main_config import *

wired.init_ports(inputs, outputs)
wired.buttons_clear(outputs)

wireless.init_module()
wireless.buttons_clear(channels)

pressed = False

while True:

    for i in channels:
        received = wireless.listen(i)
        if received and not pressed:
            pressed = True
            wireless.send(received, received, 100)  # Can be 100 or more, we don't need to receive anything for a


    for i in range(len(inputs)):
        if GPIO.input(inputs[i]) == GPIO.HIGH and not pressed:
            pressed = True
            GPIO.output(outputs[i], GPIO.HIGH)

    if pressed:
        break