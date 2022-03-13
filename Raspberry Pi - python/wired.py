import time
import RPi.GPIO as GPIO


def init_ports(inputs, outputs):
    GPIO.setmode(GPIO.BCM)
    GPIO.setwarnings(False)

    for i in inputs:
        GPIO.setup(i, GPIO.IN, pull_up_down=GPIO.PUD_DOWN)

    for o in outputs:
        GPIO.setup(o, GPIO.OUT, initial=GPIO.LOW)


# block players holding their buttons before the music starts
def block_cheaters(inputs):
    blocked = []
    for i in range(len(inputs)):
        blocked.append(False)
    for i in range(len(inputs)):
        if GPIO.input(inputs[i]) == GPIO.HIGH:
            blocked[i] = True
    return (blocked)


def buttons_clear(outputs):
    for o in outputs:
        GPIO.output(o, GPIO.LOW)
