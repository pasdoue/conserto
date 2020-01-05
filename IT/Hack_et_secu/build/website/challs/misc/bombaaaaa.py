#!/usr/bin/env python
# -*- coding: utf-8 -*-
import os
import time
import random
import Adafruit_CharLCD as LCD
import RPi.GPIO as GPIO
from solucioooon import soluciooon

rs			= 27
en			= 22
d4			= 25
d5			= 24
d6			= 23
d7			= 18
r			= 4
g 			= 17
b 			= 7
columns 	= 16
rows 		= 2
countdown	= 40
countdown_init = countdown
l_g 		= 26
l_y 		= 13
l_r 		= 19
w_g 		= 5
w_y 		= 21
w_r 		= 6
w_b 		= 20
w = [w_g, w_y, w_r, w_b]
l = [l_g, l_y, l_r]
s = ["ouch","aie","..."]
p_s = [False, False, False, False]

# Initialize the LCD using the pins above.
lcd = LCD.Adafruit_RGBCharLCD(rs, en, d4, d5, d6, d7, columns, rows, r, g, b)


def tadaaa():
	for x in l:
		GPIO.setmode(GPIO.BCM)
		GPIO.setup(x, GPIO.OUT)
		GPIO.output(x, GPIO.LOW)

def amazing():
	for x in w:
		GPIO.setmode(GPIO.BCM)
		GPIO.setup(x, GPIO.IN, pull_up_down=GPIO.PUD_UP)

def wahouuu(l):
	GPIO.output(l, GPIO.HIGH)


def what_are_you_looking_at(curr_time):
	global countdown
	if curr_time > int(2*countdown_init/3):
		return s[0]
	elif curr_time > int(1*countdown_init/3):
		return s[1]
	elif curr_time <= int(1*countdown_init/3):
		return s[2]

def toto(message, col):
	lcd.clear()
	if col == "r":
		lcd.set_color(1.0, 0.0, 0.0)
	elif col == "g":
		lcd.set_color(0.0, 1.0, 0.0)
	elif col == "y":
		lcd.set_color(1.0, 1.0, 0.0)
	lcd.message(message)

def fucking_functions_name():
	if not False in p_s:
		toto("Succeed!", "g")
		time.sleep(3)
		return True
	return False


def boooom(countdown):
	amazing()
	tadaaa()
	while countdown:
		mins, secs = divmod(countdown, 60)
		timeformat = '{:02d}:{:02d}'.format(mins, secs)
		lcd.clear()
		lcd.message(timeformat)
		what = 60*mins+secs
		hoho = what_are_you_looking_at(what)

		for x in w:
			if what%2 == 0 and w.index(x)%2 == 0 and GPIO.input(x) == True and p_s[w.index(x)] == False :
				p_s[w.index(x)] = True
				break
			elif what%2 == 1 and w.index(x)%2 == 1 and GPIO.input(x) == True and p_s[w.index(x)] == False :
				p_s[w.index(x)] = True
				break
			elif GPIO.input(x) == True and p_s[w.index(x)] == False :
				toto("You died!", "r")
				return

		if hoho == s[2]:
			lcd.set_color(1.0, 0.0, 0.0)
			wahouuu(l_r)
		elif hoho == s[0]:
			lcd.set_color(0.0, 1.0, 0.0)
			wahouuu(l_g)
		elif hoho == s[1]:
			lcd.set_color(1.0, 1.0, 0.0)
			wahouuu(l_y)

		if fucking_functions_name() : 
			soluciooon()
			return

		time.sleep(1)
		countdown -= 1
	toto("Explosion!", "r")
	return

boooom(countdown)