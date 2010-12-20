import re
import ast
import os
import sys

class Wrapper():
    def __init__(self):
        self.users = dict()
        self.extentions = dict()
        self.directories = dict()
        self.runtime = float()
        self.map = {'Users':self.users,'Extentions':self.extentions,
                    'Directories':self.directories, 'Runtime':self.runtime}
        self.order = ['size', 'capacity', 'posOverhead', 'negOverhead', 'atime', 'ctime', 'mtime']

    def wrap(self, path):
        outputOBJ = open(path,'r')
        fullTxt = []
        for line in outputOBJ:
            if line.splitlines()[0] != '':
                fullTxt.append(line.splitlines()[0].rstrip().lstrip())
        counter  = 0
        dirCounter = 0
        tmpKey = 'None'
        for line in fullTxt:
            if line.partition('=')[1] != '=':
                if tmpKey != 'Directories':
                    keyList =self.map.keys()
                    if line in keyList:
                        tmpKey = line
                        if tmpKey != 'Directories':
                            if fullTxt[counter +1] not in self.map[tmpKey]:
                                self.map[tmpKey][fullTxt[counter +1]] = {}
                                subCounter = 2
                                for item in self.order:
                                    self.map[line][fullTxt[counter + 1]][item] = ast.literal_eval(fullTxt[counter + subCounter])
                                    subCounter = subCounter + 1
                            else:
                                subCounter = 2
                                for item in self.order:
                                    weighted = ast.literal_eval(fullTxt[counter + subCounter])[0]
                                    counted = ast.literal_eval(fullTxt[counter + subCounter])[1]
                                    for keys in weighted:
                                        if keys not in self.map[tmpKey][fullTxt[counter +1]][item][0]:
                                            self.map[tmpKey][fullTxt[counter +1]][item][0][keys] = weighted[keys]
                                        else:
                                            self.map[tmpKey][fullTxt[counter +1]][item][0][keys] += weighted[keys]
                                    for keys in counted:
                                        if keys not in self.map[tmpKey][fullTxt[counter +1]][item][1]:
                                            self.map[tmpKey][fullTxt[counter +1]][item][1][keys] = counted[keys]
                                        else:
                                            self.map[tmpKey][fullTxt[counter +1]][item][1][keys] += counted[keys]
                                    subCounter = subCounter + 1
                        else:
                            if fullTxt[counter +1] not in self.map[tmpKey]:
                                self.map[tmpKey][fullTxt[counter + 1]] = {}
                                self.map[tmpKey][fullTxt[counter + 1]]['links'] = ast.literal_eval(fullTxt[counter + 2])
                                dirCounter = dirCounter + 1
                            else:
                                weighted = ast.literal_eval(fullTxt[counter + 2])[0]
                                counted = ast.literal_eval(fullTxt[counter + 2])[1]
                                for keys in weighted:
                                    if keys not in self.map[tmpKey][fullTxt[counter + 1]]['links']:
                                        self.map[tmpKey][fullTxt[counter + 1]]['links'][0][keys] = weighted[keys]
                                    else:
                                        self.map[tmpKey][fullTxt[counter + 1]]['links'][0][keys] += weighted[keys]
                                for keys in counted:
                                    if keys not in self.map[tmpKey][fullTxt[counter + 1]]['links']:
                                        self.map[tmpKey][fullTxt[counter + 1]]['links'][1][keys] = counted[keys]
                                    else:
                                        self.map[tmpKey][fullTxt[counter + 1]]['links'][1][keys] += counted[keys]
                                dirCounter = dirCounter + 1
                else:
                    if counter < len(fullTxt)-2:
                        if dirCounter % 3 == 0:
                            if fullTxt[counter +1] not in self.map[tmpKey]:
                                self.map[tmpKey][fullTxt[counter + 1]]  = {}
                                self.map[tmpKey][fullTxt[counter+1]]['links'] = ast.literal_eval(fullTxt[counter + 2])
                                dirCounter = dirCounter + 1
                            else:
                                weighted = ast.literal_eval(fullTxt[counter + 2])[0]
                                counted = ast.literal_eval(fullTxt[counter + 2])[1]
                                for keys in weighted:
                                    if keys not in self.map[tmpKey][fullTxt[counter + 1]]['links']:
                                        self.map[tmpKey][fullTxt[counter + 1]]['links'][0][keys] = weighted[keys]
                                    else:
                                        self.map[tmpKey][fullTxt[counter + 1]]['links'][0][keys] += weighted[keys]
                                for keys in counted:
                                    if keys not in self.map[tmpKey][fullTxt[counter + 1]]['links']:
                                        self.map[tmpKey][fullTxt[counter + 1]]['links'][1][keys] = counted[keys]
                                    else:
                                        self.map[tmpKey][fullTxt[counter + 1]]['links'][1][keys] += counted[keys]
                                dirCounter = dirCounter + 1
                        else:
                            dirCounter = dirCounter + 1
            else:
                if self.map['Runtime'] == float():
                    self.map['Runtime'] = float(line.partition('=')[2])
                else:
                    self.map['Runtime'] += float(line.partition('=')[2])
                tmpKey = 'None'
            counter = counter + 1

    def getDict(self):
        retDict = dict()
        for keys in self.map:
            #print keys
            if keys != 'Runtime':
                retDict[keys] = dict()
                for key in self.map[keys]:
                    #print ''
                    #print keys
                    retDict[keys][key] = dict()
                    categories = ast.literal_eval(str(self.map[keys][key]))
                    for catKey in categories:
                        retDict[keys][key][catKey] = list()
                        for entry in categories[catKey]:
                            #print catKey, entry['total']
                            retDict[keys][key][catKey].append(entry['total'])
            else:
                retDict[keys] = self.map[keys]
        return retDict

    def assembleTopScan(self,userDict,extDict,dirDict,runtime):
        topDict = {0:{'Directories':dict(),'Runtime':float(),
                   'Extentions':dict(),'Users':dict()}}
        topDict[0]['Runtime'] = runtime
        for key in userDict.keys():
            for category in self.order:
                tempDict = userDict[key].binsRef
                topDict[0]['Users'][category] = [tempDict[category][0]['total'], tempDict[category][1]['total']]
        for key in extDict.keys():
            for category in self.order:
                tempDict = extDict[key].binsRef
                topDict[0]['Extentions'][category] = [tempDict[category][0]['total'], tempDict[category][1]['total']]
        for key in dirDict.keys():
            for category in ['links']:
                tempDict = dirDict[key].binsRef
                topDict[0]['Directories'][category] = [tempDict[category][0]['total'], tempDict[category][1]['total']]
        #print topDict
        return topDict




'''wrap = Wrapper()
wrap.wrap(sys.argv[1])
print wrap.getDict()'''
                        


                        
        
           
