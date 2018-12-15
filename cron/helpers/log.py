import time

from datetime import datetime, timedelta
from helpers import File

class Log():
    def __init__(self, filename):
        self.filename = filename

        self.file = File()

    def begin(self):
        self.start_time = time.time()

        self.write('--- start at {0} ---'.format(str(datetime.today() + timedelta(hours=2))))

    def finish(self):
        self.write("--- finish at {0}, duration: {1} ---".format(str(datetime.today() + timedelta(hours=2)), self.duration()))

    def write(self, msg):
        f = self.file.write_a(self.filename, 'log')
        f.write(msg + '\n')
        f.close()

        #output to the console
        print(msg)

    def duration(self):
        result = time.time() - self.start_time

        if result > 60:
            result = round(result / 60, 4)
            per = 'min'
        else:
            result = round(result, 4)
            per = 'sec'

        return "{0} {1}".format(result, per)

