import re
import sys
import json
import pickle

# Argumen check
if len(sys.argv) != 6:  
    print("\n\nPenggunaan\n\tquery.py [index.txt] [n] [query] [place] [kecamatan] [bentuk]\n")
    sys.exit(1)

query = sys.argv[3].split(" ")
n = int(sys.argv[2])
place = sys.argv[4]  
kecamatan = sys.argv[5]
# bentuk = sys.argv[6]

with open(sys.argv[1], 'rb') as indexdb:
    indexFile = pickle.load(indexdb)

# Query
list_doc = {}
for q in query:
    try:
        for doc in indexFile[q]:
            if doc['sekolah'] in list_doc:
                list_doc[doc['sekolah']]['score'] += doc['score']
            else:
                list_doc[doc['sekolah']] = doc
    except:
        continue

if place:
    filtered_list = {}
    for school, doc in list_doc.items():
        if doc['kabupaten_kota'] == place:
            filtered_list[school] = doc
    list_doc = filtered_list

if kecamatan:
    filtered_list = {}
    for school, doc in list_doc.items():
        if doc['kecamatan'] == kecamatan:
            filtered_list[school] = doc
    list_doc = filtered_list

list_data = []
for data in list_doc:
    list_data.append(list_doc[data])

count = 1
for data in sorted(list_data, key=lambda k: k['score'], reverse=True):
    y = json.dumps(data)
    print(y)
    if count == n:
        break
    count += 1
