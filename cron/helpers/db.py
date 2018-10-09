import cymysql

class Db():
    host = 'localhost'
    user = 'root'
    password = ''
    db = 'coincontrol'

    def __init__(self):
        self.conn = self.connect()

    def connect(self):
        return cymysql.connect(host=self.host, user=self.user, passwd=self.password, db=self.db)

    def close(self):
        self.conn.close();

    def get_sites(self):
        cur = self.conn.cursor()
        cur.execute("SELECT id, link, slug, publish FROM tbl__settings_sites")# WHERE publish=1

        result = cur.fetchall()
        cur.close()

        return result

    def get_posts(self, type, created):
        cur = self.conn.cursor()
        cur.execute("SELECT title FROM tbl__posts WHERE publish=1 AND type='{0}' AND created_at>={1}".format(type, created))

        result = cur.fetchall()
        cur.close()

        return result

    def get_handbook(self):
        cur = self.conn.cursor()
        cur.execute("SELECT id, title, check_case FROM tbl__handbook WHERE publish=1")

        result = cur.fetchall()
        cur.close()

        return result

    def get_import(self, type):
        cur = self.conn.cursor()
        cur.execute("SELECT id FROM tbl__import WHERE type='{0}' AND import=1 LIMIT 1".format(type))

        result = cur.fetchone()
        cur.close()

        if result != None:
            return True
        else:
            return False

    def set_import(self, type, value):
        cur = self.conn.cursor()
        cur.execute("UPDATE tbl__import SET import={1} WHERE type='{0}'".format(type, value))
        cur.close()
        self.conn.commit()
