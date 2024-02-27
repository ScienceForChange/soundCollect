import maad
from maad import spl, sound
import numpy as np

return_array = []

# input sound file
w, fs = maad.sound.load('Oficina-Z.wav') 
p = maad.spl.wav2pressure(wave=w, gain=0)
maad.spl.pressure2dBSPL(abs(p))

# calculare Leq
p_rms = maad.util.rms(p)
maad.spl.pressure2dBSPL(p_rms) 

x =  maad.spl.pressure2dBSPL(abs(p))

#split x into 1000 arrays, on a sample 1 minute WAV audio it had 2.8 milion values
splitted_x_into_1000_arrays = np.array_split(x, 1000)

# create a median array
median_array = []
for i in splitted_x_into_1000_arrays:
    median_array.append(float(np.mean(i)))

# create a return array
# add Lmin
return_array.append('Lmin: ' + str(min(median_array)) + ' dB')
# add Lmax
return_array.append('Lmax: ' + str(max(median_array)) + ' dB')
# add Leq
return_array.append('Leq: ' + str(maad.spl.pressure2dBSPL(p_rms)) + ' dB')

print(return_array)

