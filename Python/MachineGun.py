import pygame as pg
import settings as st

class MachineGun:
    
    def __init__(self, x, y, display, nr):
        self.x = x
        self.y = y
        self.display = display
        self.pg = pg
        self.nr = nr
    
    def gunner(self):
        pg.draw.rect(self.display, st.yellow, (self.x, self.y, 2, 5), 0)
    
    def shot(self):
        self.y -= 5