# configure which Raspberry GPIOs are used for wired buttons
# order matters - output[n] should be LED paired with input[n] button
inputs = (5, 22, 27, 17, 4, 13)
outputs = (12, 25, 24, 23, 18, 21)

# configure radio channels for wireless buttons
channels = (7, 14, 21, 35, 42)

# configure path to 'pause' file created by php when admin presses pause button
path = "/home/pi/touches/pause"
