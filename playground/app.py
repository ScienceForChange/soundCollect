import os
from flask import Flask
import maad
import sys
from maad import spl, sound
import numpy as np
import json

app = Flask(__name__)

@app.route("/")
def main():
    return "You're home!"

# @app.route('/hello-world')
# def hello_world():
#     return 'Hello World'

@app.route('/audio')
def audio():

    response = {}

    # input sound file
    w, fs = maad.sound.load('./audio/Oficina-X.WAV')
    p = maad.spl.wav2pressure(wave=w, gain=0)
    maad.spl.pressure2dBSPL(abs(p))

    # calculare Leq
    p_rms = maad.util.rms(p)
    maad.spl.pressure2dBSPL(p_rms)

    x =  maad.spl.pressure2dBSPL(abs(p))

    #split x into 1000 arrays, on a sample 1 minute W AV audio it had 2.8 milion values
    splitted_x_into_1000_arrays = np.array_split(x, 10)

    # create a 1000 values median array
    median_array = []
    for i in splitted_x_into_1000_arrays:
        median_array.append(float(np.mean(i)))

    # sort the median array to get L90 and L10
    sorted_median_array = sorted(median_array)
    L90 = sorted_median_array[int(len(median_array)*0.1)]
    L10 = sorted_median_array[int(len(median_array)*0.9)]

    # create a response
    # add Lmin
    response['Lmin'] = min(median_array)
    # add Lmax
    response['Lmax'] = max(median_array)
    # add Leq
    response['Leq'] = maad.spl.pressure2dBSPL(p_rms)
    # add LAeq,T
    response['LAeqT'] = median_array
    # add L90
    response['L90'] = L90
    # add L10
    response['L10'] = L10

    # return json.dumps(response)
    return response

if __name__ == "__main__":
    app.run(debug=True)
