/*
	Biblioteka RFM70 dla AVR'�w oparta na projekcie Daniela z http:://projects.web4clans.com
	
	Autor: freakone
	WWW: freakone.pl
	@: kamil@freakone.pl
*/

#include "uart.h" // je�li chcemy korzysta� z uarta
#define DEBUG 1 // je�li chcemy debugowa� - uart r�wnie� musi by� zainkludowany

//RFM70
#define DDR_SPI DDRB
#define PORT_SPI PORTB
#define SCK  PB5
#define MISO PB4
#define MOSI PB3
#define CE   PB0
#define CSN  PB2

//DIODA
#define DDR_BLINK DDRD
#define PORT_BLINK PORTD
#define RED PD6
#define GREEN PD5

#define RED_LED_SET        PORT_BLINK |= (1 << RED)
#define RED_LED_CLR        PORT_BLINK &=~(1 << RED)

#define GREEN_LED_SET        PORT_BLINK |= (1 << GREEN)
#define GREEN_LED_CLR        PORT_BLINK &=~(1 << GREEN)
