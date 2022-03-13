import wired
import wireless
from main_config import *

wired.init_ports(inputs, outputs)
wired.buttons_clear(outputs)

wireless.init_module()
wireless.buttons_clear(channels)
