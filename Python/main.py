# Modules
import pygame as pg
import time
import settings as st
import random as rnd

# Classes
import MachineGun as mg
import Island as isl

pg.init()

# Window and time setup
game_display = pg.display.set_mode((st.display_width, st.display_height))
clock = pg.time.Clock()
pg.display.set_caption("Midway 1942")

# Load images
waves = pg.image.load("img/waves.png")
plane = pg.image.load("img/hero-plane.png")

def hero_plane(x, y):
    game_display.blit(plane, (x, y))

def background(x, y):
    game_display.blit(waves, (x, y))

def game_loop():
    game_running = True

    # Plane specs
    plane_x = ((st.display_width / 2) - (plane.get_width() / 2)) # Place in the middle
    plane_y = (st.display_height * 0.7)
    plane_speed = 7

    # Wave specs
    wave_a_y = 0
    wave_b_y = 0

    # Shot specs
    shot_speed = 5
    shot_list = []
    shot_nr = 0
    new_shot = mg.MachineGun(250, 600, game_display, shot_nr)

    # Island specs
    island_pos = rnd.randint(0, 500)
    island = isl.Island(island_pos, -200, 200, 200, game_display)
    island_freq = 500

    pg.key.set_repeat(25, 25)

    while game_running:
        for event in pg.event.get():
            
            # Quit option
            if event.type == pg.QUIT:
                game_running = False
        
        # Draw elements
        game_display.fill(st.blue)
        background(0, wave_a_y)
        background(0, wave_b_y - st.display_height)
        island.print_island()
        hero_plane(plane_x, plane_y)

        # Keys event pressed down
        if event.type == pg.KEYDOWN:
            if event.key == pg.K_LCTRL:
                new_shot
                new_shot.gunner()
                new_shot.shot()
            elif event.key == pg.K_LEFT:
                plane_x -= plane_speed
            elif event.key == pg.K_RIGHT:
                plane_x += plane_speed
            elif event.key == pg.K_UP:
                plane_y -= plane_speed
            elif event.key == pg.K_DOWN:
                plane_y += plane_speed
        if event.type == pg.KEYUP:
            if event.key == pg.K_LCTRL:
                pass
                
        # Move elements
        wave_a_y += 1
        wave_b_y += 1
        island.flyby()
        
        # Check for wave exiting screen
        if wave_a_y >= st.display_height:
            wave_a_y = 0
        elif wave_b_y >= st.display_height:
            wave_b_y = 0

        # Loop ending
        pg.display.update()
        clock.tick(st.fps)

game_loop()
pg.quit()