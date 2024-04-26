import os
import re

# pwd = os.getcwd()
# files = os.listdir(pwd + "/result")
# pattern = r"\[.*?\]"
# for myfile in files:
#     fileJson = open("newline/"+myfile, "rb")
#     rawData = fileJson.read().decode("utf-8")
#     result = re.sub(pattern, lambda x: x.group(0).replace(']}', ''), rawData)
#     newFile = open("kurungsikubelakang/"+myfile, "wb")
#     newFile.write(result.encode("utf-8"))
#     newFile.close()


# Mengonversi data ke dalam bentuk json dengan new line setelah ketemu tanda kurung kurawal

# pwd = os.getcwd()
# files = os.listdir(pwd + "/result") 
# pattern = r'}'

# for myfile in files:
#     fileJson = open("konversi/"+myfile, "rb")
#     rawData = fileJson.read().decode("utf-8")
#     result = re.sub(pattern, lambda x: x.group(0) + '\n', rawData)
#     newFile = open("newline/"+myfile, "wb")
#     newFile.write(result.encode("utf-8"))
#     newFile.close()

# Mengonversi data ke dalam bentuk json dengan new line setelah kurung ] dan data sebelum kurung [
pwd = os.getcwd()
files = os.listdir(pwd + "/result")
for myfile in files:
    fileJson = open("newline/"+myfile, "rb")
    rawData = fileJson.read().decode("utf-8")
    result_without_right_bracket = re.sub(r'\].*', '', rawData)
    result = re.sub(r'.*\[', '', result_without_right_bracket)
    newFile = open("tanpakurungsiku/"+myfile, "wb")
    newFile.write(result.encode("utf-8"))
    newFile.close()