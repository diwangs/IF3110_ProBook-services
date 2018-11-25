cd src
javac -cp ../lib/*:. *.java
jar cfm BookService.jar MANIFEST.MF *.class
rm *.class
mkdir ../bin &> /dev/null
mv BookService.jar ../bin
cd ..