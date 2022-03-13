#include <inttypes.h>
#include <avr/io.h>
#include <util/delay.h>
#include "rfm70.h"

int main()
{
	DDRD &= ~(1 << PD2);
	PORTD |= (1 << PD2);

	uint8_t channel = 28; //7, 14, 21, 28, 35, different for each wireless button

	uint8_t button_state=0;
	uint8_t my_code[]={channel};
	uint8_t reset[]={'z'};

	initRFM();
	setModeRX();
	setChannel(channel);
	setPower(3); 

	uint8_t bufor[] = {'x'};
	RED_LED_SET;
	uint8_t sent = 0;

	while (1)
	{

		if (!(PIND & (1<<PD2)))  {
			button_state=1;
			RED_LED_CLR;
		}
		if (button_state==1&&sent==0)  {
			setModeTX();
			sent = 1;
			_delay_ms(20);
			for (int i=0; i<250; i++){
				sendPayload(my_code, 1, 1);
			}
			setModeRX();
		}

		if (receivePayload(bufor)){

			if (bufor[0]==my_code[0]){
			GREEN_LED_SET;
			}

			if (bufor[0]==reset[0]){
			GREEN_LED_CLR;
			RED_LED_SET;
			sent = 0;
			button_state=0;
			}
		}
	}
}
