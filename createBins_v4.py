class Bin:
        
    def binDrop(self, value, binLim, weight, count, key, size):
        for oneBin in binLim:
            if value <= oneBin:
                if "bin"+str(binLim.index(oneBin)) not in weight:
                    if key not in ['atime','ctime','mtime']:
                        weight["bin"+str(binLim.index(oneBin))] = value
                    else:
                        weight["bin"+str(binLim.index(oneBin))] = size
                    count["bin"+str(binLim.index(oneBin))] = 1
                else:
                    if key not in ['atime','ctime','mtime']:
                        weight["bin"+str(binLim.index(oneBin))] += value
                    else:
                        weight["bin"+str(binLim.index(oneBin))] += size
                    count["bin"+str(binLim.index(oneBin))] += 1
                    
                break
            elif binLim.index(oneBin) == (len(binLim)-1):
                if value <= oneBin:
                    if "bin"+str(binLim.index(oneBin)) not in weight:
                        if key not in ['atime','ctime','mtime']:
                            weight["bin"+str(binLim.index(oneBin))] = value
                        else:
                            weight["bin"+str(binLim.index(oneBin))] = size
                        count["bin"+str(binLim.index(oneBin))] = 1
                    else:
                        if key not in ['atime','ctime','mtime']:
                            weight["bin"+str(binLim.index(oneBin))] += value
                        else:
                            weight["bin"+str(binLim.index(oneBin))] += size
                        count["bin"+str(binLim.index(oneBin))] += 1
                else:
                    if "bin"+str(binLim.index(oneBin)+1) not in weight:
                        if key not in ['atime','ctime','mtime']:
                            weight["bin"+str(binLim.index(oneBin)+1)] = value
                        else:
                            weight["bin"+str(binLim.index(oneBin)+1)] = size
                        count["bin"+str(binLim.index(oneBin)+1)] = 1
                    else:
                        if key not in ['atime','ctime','mtime']:
                            weight["bin"+str(binLim.index(oneBin)+1)] += value
                        else:
                            weight["bin"+str(binLim.index(oneBin)+1)] += size
                        count["bin"+str(binLim.index(oneBin)+1)] += 1
        return weight,count
