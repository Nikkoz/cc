from datetime import datetime, timedelta

import numpy

class Union():
    def start_import(self):
        if self.db.get_import(self.type):
            return False
        else:
            self.db.set_import(self.type, 1)
            self.log.begin()

        return True

    def finish_import(self):
        self.db.set_import(self.type, 0)
        self.log.finish()

    def day_ago(self):
        return int((datetime.today() - timedelta(hours=24)).timestamp())

    def get_day(self):
        return datetime.today().strftime("%d/%m/%y %H:%s")

    def merge(self, arr1, arr2):
        a = numpy.array(arr1)
        b = numpy.array(arr2)

        return numpy.hstack([a, b])