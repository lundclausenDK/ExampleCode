import pandas as ps
import numpy as np
import matplotlib.pyplot as plt
from operator import itemgetter

#   For the main-category with the most successfully funded projects (quantity, not rate of success), what is the goal-
#   amount range (usd_goal_real), e.g. range 0-10k$ , 5-15k$, 100k$-110k$

filename = "ks-projects-201801.csv"
data = ps.read_csv(filename)


def question_5():
    # Lets create a dataframe to work with
    df = ps.DataFrame(data)

    # Then lets subtract the column names we need
    cats = list(df.columns.values)
    main_cat = cats[3]
    name = cats[1]
    goal = cats[6]
    curr = cats[4]
    state = cats[9]

    # We also want the names of main categories
    areas = df.main_category.unique()

    # Now select the only the needed rows and columns
    new_set = df.loc[(df[state] == 'successful') & (df[curr] == 'USD'),  [name, main_cat, goal, curr, state]]

    # Lets sort from high to low by our goal
    sorted_set = new_set.sort_values(by=[main_cat, goal], ascending=False)

    # Then lets sorted subtracts by main category
    publish = sorted_set.loc[sorted_set[main_cat] == areas[0]]
    films = sorted_set.loc[sorted_set[main_cat] == areas[1]]
    music = sorted_set.loc[sorted_set[main_cat] == areas[2]]
    food = sorted_set.loc[sorted_set[main_cat] == areas[3]]
    design = sorted_set.loc[sorted_set[main_cat] == areas[4]]
    crafts = sorted_set.loc[sorted_set[main_cat] == areas[5]]
    games = sorted_set.loc[sorted_set[main_cat] == areas[6]]
    comics = sorted_set.loc[sorted_set[main_cat] == areas[7]]
    fashion = sorted_set.loc[sorted_set[main_cat] == areas[8]]
    theater = sorted_set.loc[sorted_set[main_cat] == areas[9]]
    art = sorted_set.loc[sorted_set[main_cat] == areas[10]]
    photo = sorted_set.loc[sorted_set[main_cat] == areas[11]]
    tech = sorted_set.loc[sorted_set[main_cat] == areas[12]]
    dance = sorted_set.loc[sorted_set[main_cat] == areas[13]]
    jour = sorted_set.loc[sorted_set[main_cat] == areas[14]]

    # For full precise answering, lets print all categories and goals
    print(games.iloc[0][goal], games.iloc[-1][goal], games.iloc[0][main_cat] + ": " + games.iloc[0][name])
    print(films.iloc[0][goal], films.iloc[-1][goal], films.iloc[0][main_cat] + ": " + films.iloc[0][name])
    print(tech.iloc[0][goal], tech.iloc[-1][goal], tech.iloc[0][main_cat] + ": " + tech.iloc[0][name])
    print(design.iloc[0][goal], design.iloc[-1][goal], design.iloc[0][main_cat] + ": " + design.iloc[0][name])
    print(art.iloc[0][goal], art.iloc[-1][goal], art.iloc[0][main_cat] + ": " + art.iloc[0][name])
    print(photo.iloc[0][goal], photo.iloc[-1][goal], photo.iloc[0][main_cat] + ": " + photo.iloc[0][name])
    print(food.iloc[0][goal], food.iloc[-1][goal], food.iloc[0][main_cat] + ": " + food.iloc[0][name])
    print(fashion.iloc[0][goal], fashion.iloc[-1][goal], fashion.iloc[0][main_cat] + ": " + fashion.iloc[0][name])
    print(comics.iloc[0][goal], comics.iloc[-1][goal], comics.iloc[0][main_cat] + ": " + comics.iloc[0][name])
    print(publish.iloc[0][goal], publish.iloc[-1][goal], publish.iloc[0][main_cat] + ": " + publish.iloc[0][name])
    print(music.iloc[0][goal], music.iloc[-1][goal], music.iloc[0][main_cat] + ": " + music.iloc[0][name])
    print(theater.iloc[0][goal], theater.iloc[-1][goal], theater.iloc[0][main_cat] + ": " + theater.iloc[0][name])
    print(jour.iloc[0][goal], jour.iloc[-1][goal], jour.iloc[0][main_cat] + ": " + jour.iloc[0][name])
    print(dance.iloc[0][goal], dance.iloc[-1][goal], dance.iloc[0][main_cat] + ": " + dance.iloc[0][name])
    print(crafts.iloc[0][goal], crafts.iloc[-1][goal], crafts.iloc[0][main_cat] + ": " + crafts.iloc[0][name])

    # We are done data-grinding, lets show the results
    top_cats = [
        games.iloc[0][main_cat] + ": " + games.iloc[0][name],
        films.iloc[0][main_cat] + ": " + films.iloc[0][name],
        tech.iloc[0][main_cat] + ": " + tech.iloc[0][name],
        design.iloc[0][main_cat] + ": " + design.iloc[0][name],
        art.iloc[0][main_cat] + ": " + art.iloc[0][name]
    ]

    top_goals = [
        games.iloc[0][goal],
        films.iloc[0][goal],
        tech.iloc[0][goal],
        design.iloc[0][goal],
        art.iloc[0][goal]
    ]

    y_pos = np.arange(len(top_cats))
    plt.barh(y_pos, top_goals)
    plt.yticks(y_pos, top_cats)
    plt.xlabel('Goal in USD')
    plt.title('Top 5 - Most successfully funded projects by goal-amount range')
    plt.tight_layout()
    plt.show()


question_5()