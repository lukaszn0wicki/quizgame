import mutagen.mp3
import pygame
import sys
import os
from time import sleep
import wired
import RPi.GPIO as GPIO
import wireless
from main_config import *

def wait_for_unpause():
    paused = True
    while paused:
        sleep(0.2)
        if pause_file_exists():
            paused = False
            wired.buttons_clear(outputs)
            wireless.buttons_clear(channels)
            pygame.mixer.music.unpause()


def pause_if_paused_by_admin():
    if pause_file_exists():
        pygame.mixer.music.pause()
        wait_for_unpause()


def pause_file_exists():
    if os.path.isfile(path):
        sleep(0.05)
        os.remove(path)
        return True
    else:
        return False


wired.init_ports(inputs, outputs)
wired.buttons_clear(outputs)
blocked = wired.block_cheaters(inputs)

wireless.init_module()
wireless.buttons_clear(channels)
#  no need to block wireless cheaters - wireless modules block after transmission anyway


song_file = sys.argv[1]
mp3 = mutagen.mp3.MP3(song_file)
frequency = mp3.info.sample_rate
pygame.mixer.init(frequency)
pygame.mixer.music.load(song_file)
pygame.mixer.music.play()
pygame.mixer.music.pause()  # pause immediately, let the admin unpause manually
pause_file_exists() # Remove garbage pause file if exists
wait_for_unpause()

while True:

    pause_if_paused_by_admin()

    for i in channels:
        received = wireless.listen(i)
        if received:
            pygame.mixer.music.pause()
            print(received)
            wireless.send(received, received, 100)  # Can be 100 or more, we don't need to receive anything for a while
            wait_for_unpause()

    for i in range(len(inputs)):
        if GPIO.input(inputs[i]) == GPIO.HIGH and not blocked[i]:
            pygame.mixer.music.pause()
            GPIO.output(outputs[i], GPIO.HIGH)
            wait_for_unpause()
            blocked = wired.block_cheaters(inputs)
