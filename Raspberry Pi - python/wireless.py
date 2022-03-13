import rfm75
from time import sleep


def buttons_clear(channels):
    for chan in channels:
        send('z', chan, 25)  # 25 should be enough and yet not take too long


def init_module():
    rfm75.init(5)
    sleep(0.05)
    rfm75.init_banks()
    sleep(0.05)


def listen(channel):
    rfm75.set_channel(channel)
    status = rfm75.register_read(0x07)
    if status & (1 << 6):
        received = rfm75.receive()[0][0]
        return received
    else:
        return False


def send(data, channel, retransmittion):
    rfm75.transmit_mode()
    rfm75.set_channel(channel)
    for i in range(retransmittion):
        rfm75.transmit(data)
        sleep(0.005)
    rfm75.receive_mode()  # return to receive mode - this should be default state of rfm75
