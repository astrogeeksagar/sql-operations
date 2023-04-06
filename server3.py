import os
import time
from io import BytesIO
import mysql.connector
import requests
import concurrent.futures
from PIL import Image

# database credentials
servername = "localhost"
username = "root"
password = ""
dbname = "sagar"

# create database connection pool
pool = mysql.connector.pooling.MySQLConnectionPool(
    pool_name="db_conn_pool",
    pool_size=5,
    host=servername,
    user=username,
    password=password,
    database=dbname,
)

session = requests.Session()

# download image files


def download_image(row):
    image_link = row[1]
    readid = row[0]
    file_name = os.path.basename(image_link)
    response = session.get(image_link)
    if response.status_code == 404:
        print(file_name + " not found")
    else:
        # https://www.instagram.com/geek_sagar/
        filepath = "./FebMar2023/" + file_name
        if os.path.exists(filepath):
            print("Image already exists : " + file_name)
        else:
            with open(filepath, "wb") as f:
                image = Image.open(BytesIO(response.content))
                image.save(filepath, optimize=True, quality=60)
                print(f"{readid} {file_name} has been downloaded✅")


# get database connection from the pool
conn = pool.get_connection()
cursor = conn.cursor()

# SQL query to fetch data
sql = "SELECT `reading_id`, `meter_photo` FROM mtrjan WHERE `reading_id`>=96000 AND `reading_id`<=98514"
# 98514 last
cursor.execute(sql)

start_time = time.time()
counter = 0
with concurrent.futures.ThreadPoolExecutor(max_workers=20) as executor:
    futures = [executor.submit(download_image, row)
               for row in cursor.fetchall()]
    for future in concurrent.futures.as_completed(futures):
        counter += 1
        current_time = time.time()
        time_elapsed = current_time - start_time
        estimated_time = (time_elapsed / counter) * cursor.rowcount
        time_remaining = estimated_time - time_elapsed
        hours = int(time_remaining // 3600)
        minutes = int((time_remaining % 3600) // 60)
        seconds = int(time_remaining % 60)
        print(f"{cursor.rowcount - counter} photos left to download. Time remaining : {hours} hours {minutes} minutes {seconds} seconds")

# close database connection
conn.close()

# https://www.instagram.com/geek_sagar/
