#!/usr/bin/python
import sys, getopt
import os
import mysql.connector
from xml.dom import minidom
from datetime import datetime
import time

print "----------------------------"
print "Import XML in MySQL database, start", time.strftime("%H:%M:%S", time.localtime())
print 'Number of arguments:', len(sys.argv), 'arguments.'
print 'Argument List:', str(sys.argv)

mydb = mysql.connector.connect(host="localhost", user="xml_demo", password="xml_demo", database="XML_demo")
global myCursor
myCursor=mydb.cursor()

class color:
   PURPLE = '\033[95m'
   CYAN = '\033[96m'
   DARKCYAN = '\033[36m'
   BLUE = '\033[94m'
   GREEN = '\033[92m'
   YELLOW = '\033[93m'
   RED = '\033[91m'
   BOLD = '\033[1m'
   UNDERLINE = '\033[4m'
   END = '\033[0m'

def insertPart(number, name, version, dimension, operation_1, operation_2, operation_3, operation_4, operation_5):
    # print "Insert part", number, " -", name
    # Check if part exists
    query = "SELECT Number, Version FROM Parts WHERE Number='" + number + "' AND Version='" + version +"'";
    myCursor.execute(query)
    myresult = myCursor.fetchall()

    # if part doesn't exist :
    if len(myresult)==0:
        #insert in database
        createdDate = datetime.now().strftime("%d/%m/%Y %H:%M:%S") # dd/mm/YY H:M:S
        query="INSERT INTO Parts (number, name, version, dimension, operation_1, operation_2, operation_3, operation_4, operation_5, Created) " + "VALUES('" + number + "', '" + name + "', '" + version + "', '" + dimension + "', '" + operation_1 + "', '" + operation_2 + "', '" + operation_3 + "', '" + operation_4 + "', '" + operation_5 + "', '" + createdDate + "')";
        myCursor.execute(query)
        mydb.commit()

def getPartID(number, version):
    # retrieve part ID from database to use in parent-child usage link
    # print "  Searching ID of part",number,"[",version,"]"
    query = "SELECT partID FROM XML_demo.Parts WHERE Number='" + number + "' AND Version='" + version +"'";
    myCursor.execute(query)
    # print "myCursor is ",myCursor.fetchone()[0]
    partID = myCursor.fetchone()[0]
    #partID = myCursor
    # print "partID is ",partID

    if partID is not None:
        a=1
        # partID = myCursor.fetchone()[0])
        # print "    ID of part",number,"[",version,"] is", color.GREEN,partID,color.END
    else:
        print color.RED+color.BOLD,"    Part ID of ",number,color.END," not found"
        #print "    ",query
    return str(partID)

def insertPartUsage(parentNumber, parentVersion, childNumber, childVersion, quantity, certificate):
    # print "Parent "+ parentNumber+ " ["+ parentVersion+ "] of child "+ childNumber+ " ["+ childVersion+ "]"
    # Check if part usage link exists

    # print "  Check for existing usage link between",parentNumber," [",parentVersion,"] and ",childNumber," [",childVersion,"]"
    parentID = getPartID(parentNumber, parentVersion)
    childID = getPartID(childNumber, childVersion)
    query = "SELECT PartUsageID FROM PartUsage WHERE ParentID='" + parentID + "' AND ChildID='" + childID +"'";
    myCursor.execute(query)
    myresult = myCursor.fetchall()
    if len(myresult)==0:
        #insert new usage link
        query="INSERT INTO PartUsage (ParentID, ChildID, Quantity, Certificate) " + "VALUES('" + parentID + "', '" + childID + "', '" + quantity + "', '" + certificate + "')";
        # print query
        myCursor.execute(query)
        mydb.commit()

def importFile(xmlFile):
    # print "Importing ", xmlFile
    xmlDoc = minidom.parse(xmlFile)
    partList=xmlDoc.getElementsByTagName('part')
    # print "  File contains ", len(partList), " parts"
    numPart=0
    # newParts=0
    # newUsageLinks=0
    for part in partList:
        numPart=numPart+1
        partNumber = part.getElementsByTagName('number')[0].firstChild.nodeValue
        partName = part.getElementsByTagName('name')[0].firstChild.nodeValue
        partVersion = part.getElementsByTagName('version')[0].firstChild.nodeValue
        # print "  Part", numPart, " :", partNumber, " [", partVersion, "] -", partName

        # Dimensions element can by empty
        partDimension=""
        partDimensionElement = part.getElementsByTagName('dimension')[0].firstChild
        if partDimensionElement is not None:
            partDimension = part.getElementsByTagName('dimension')[0].firstChild.nodeValue

        # part Operations
        operation_1=''
        operation_2=''
        operation_3=''
        operation_4=''
        operation_5=''
        operationsList = part.getElementsByTagName('operation')
        if operationsList is not None:

            if len(operationsList)>=1:operation_1 = operationsList[0].firstChild.nodeValue
            if len(operationsList)>=2:operation_2 = operationsList[1].firstChild.nodeValue
            if len(operationsList)>=3:operation_3 = operationsList[2].firstChild.nodeValue
            if len(operationsList)>=4:operation_4 = operationsList[3].firstChild.nodeValue
            if len(operationsList)>=5:operation_5 = operationsList[4].firstChild.nodeValue
            #print "Operations :", operation_1, ",", operation_2, ",", operation_3, ",", operation_4, ",", operation_5

        # print "    Part operations : ", operation_1, ",", operation_2, ",", operation_3, ",", operation_4, ",", operation_5
        insertPart(partNumber, partName, partVersion, partDimension, operation_1, operation_2, operation_3, operation_4, operation_5)

        # print part.getElementsByTagName('number').text
    partUsageList=xmlDoc.getElementsByTagName('usageLink')
    # print len(partUsageList), " links"

    numUsage=0
    for partUsage in partUsageList:
        numUsage=numUsage+1
        quantity=""
        certificate=""
        # print "Part usage", numUsage
        parent=partUsage.getElementsByTagName('parent')[0]
        parentNumber=parent.getElementsByTagName('number')[0].firstChild.nodeValue
        parentVersion=parent.getElementsByTagName('version')[0].firstChild.nodeValue
        child=partUsage.getElementsByTagName('child')[0]
        childNumber=child.getElementsByTagName('number')[0].firstChild.nodeValue
        childVersion=child.getElementsByTagName('version')[0].firstChild.nodeValue
        quantity=partUsage.getElementsByTagName('quantity')[0].firstChild.nodeValue
        certificate=partUsage.getElementsByTagName('certificate')[0].firstChild.nodeValue
        insertPartUsage(parentNumber, parentVersion, childNumber, childVersion, quantity, certificate)

    # Add imported file to log table
    now = datetime.now().strftime("%d/%m/%Y %H:%M:%S") # dd/mm/YY H:M:S
    path, filename = os.path.split(xmlFile)
    query="INSERT INTO ImportLog (filename, createDate) " + "VALUES('" + filename + "', '" + now + "')";
    myCursor.execute(query)
    mydb.commit()
    print "  Import complete,", len(partList), " parts,",len(partUsageList), " links"


xmlDirectory = ''
try:
    opts, args = getopt.getopt(sys.argv[1:],"hd:",["ifile=","ofile="])
except getopt.GetoptError:
    print "Program to import all .xml files in a specified folder"
    print "This program requires one argument for XML files directory"
    print 'Usage : importXML.py -d <xmlDirectory>'
    sys.exit(2)
for opt, arg in opts:
    if opt == '-h':
        print 'importXML.py -d <xmlDirectory>'
        sys.exit()
    elif opt in ("-d", "--xmlDirectory"):
        xmlDirectory = arg
print 'XML directory is "', xmlDirectory

# List all XML files in this directory
numFiles=0
for file in os.listdir(xmlDirectory):
    if file.endswith(".xml"):
        numFiles=numFiles+1
        print"" #insert empty line before each new file
        print "Import file",color.BOLD + color.UNDERLINE,os.path.join(xmlDirectory, file),color.END
        importFile(os.path.join(xmlDirectory, file))
print numFiles, " files found"
print "Import end", time.strftime("%H:%M:%S", time.localtime())
