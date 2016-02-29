from py2neo import neo4j, cypher
import datetime

graph_db = neo4j.GraphDatabaseService("http://localhost:7474/db/data")
#print(graph_db.neo4j_version)

relationType = []
node = graph_db.get_or_create_index(neo4j.Node, "Node")

graph_db.clear()
graph_db.refresh()

file_object = open('D:/data/string-data/4932.protein.links.detailed.v9.1.txt')
write_object = open('D:/data/string-data/4932.protein.links.detailed.v9.1.out.txt', 'w')

lineID = 0
nodeID = 0
number = 0
start = datetime.datetime.now()
start_time = datetime.datetime.now()

for line in file_object:
    lineID = lineID + 1
    strline = line.strip().split(' ')
    #print(strline)
    print(lineID)
    if(number%1000==0):
        number = 1
        end_time = datetime.datetime.now()
        write_object.write((end_time-start_time).seconds.__str__()+' s \n')
        start_time = end_time
    if (lineID == 1):
        for type in strline:
            relationType.append('type')
            print(type)
    else:
        number = number+1
        source = strline[0]
        target = strline[1]
        value2 = strline[2]
        value3 = strline[3]
        value4 = strline[4]
        value5 = strline[5]
        value6 = strline[6]
        value7 = strline[7]
        value8 = strline[8]
        value9 = strline[9]
        #print(source,target)
        sourceNode = node.get("name", source)
        #print(sourceNode.__str__())
        targetNode = node.get("name", target)
        #print(targetNode.__str__())
        if not sourceNode:
            nodeID = nodeID+1
            sourceNode_tmp, = graph_db.create({"name": source})
            node.add("name", source, sourceNode_tmp)
            sourceNode = node.get("name", source)
        if not targetNode:
            nodeID = nodeID+1
            targetNode_tmp, = graph_db.create({"name": target})
            node.add("name", target, targetNode_tmp)
            targetNode = node.get("name", target)
        #print(sourceNode.__str__())
        #print(targetNode.__str__())
        #neighborhood._get_or_create("neighborhood",value2,(sourceNode,"conn",targetNode))
        edge = graph_db.create(rel(sourceNode[0], "conn", targetNode[0], {"neighborhood":value2, "fusion": value3, "cooccurence": value4,"coexpression": value5,"experimental": value6,"database": value7, "textmining": value8, "combined_score": value9}))
    pass
end = datetime.datetime.now()
write_object.write((end-start).seconds.__str__()+' s \n')
print(nodeID)
print(lineID)