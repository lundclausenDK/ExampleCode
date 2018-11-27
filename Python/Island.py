import pygame as pg
import settings as st
import random as rnd
import time as t

class Island:
    
    def __init__(self, x, y, width, height, display):
        self.x = x
        self.y = y
        self.width = width
        self.height = height
        self.display = display
    
    def print_island(self):
        #pg.draw.rect(self.display, st.sand, (self.x, self.y, self.width, self.height), 0)
        island_img = pg.image.load("img/island01.png")
        self.display.blit(island_img, (self.x, self.y))

    
    def flyby(self):
        self.y += 1

        # When 
        if self.y >= 950:
            self.y = 0 - self.height
            self.x = rnd.randint(0, 500)
    
