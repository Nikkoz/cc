import requests
import os

from user_agent import generate_user_agent

class File():
    def set_file(self, url, type = None):
        try:
            session = requests.Session()
            session.headers.update({
                '0': 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                'Accept-Language': 'u-RU,ru;q=0.8,en-US;q=0.5,en;q=0.3',
                'Connection': 'keep-alive',
                'Cache-Control': 'max-age=0',
                'Keep-Alive': '300',
                'Accept-Charset': 'ISO-8859-1,utf-8;q=0.7,*;q=0.7',
                'Pragma': '',
                'User-Agent': generate_user_agent(device_type="desktop", os=('mac', 'linux'))
            })
            response = session.get(url, timeout=30)

            #print(url + ' - ' + str(response.status_code))

            with self.write('page', 'html') as output_file:
                output_file.write(response.text) #response.text.encode('utf-8')

        except requests.exceptions.ReadTimeout:
            self.logging(type, 'Error: Read timeout occured - ' + url)
        except requests.exceptions.ConnectTimeout:
            self.logging(type, 'Error: Connection timeout occured! - ' + url)
        except requests.exceptions.ConnectionError:
            self.logging(type, 'Seems like dns lookup failed.. - ' + url)
        except requests.exceptions.HTTPError as err:
            self.logging(type, 'Error: HTTP Error occured - ' + url)
            self.logging(type, 'Response is: {content}'.format(content=err.response.content))
        except requests.exceptions.MissingSchema as err:
            self.logging(type, 'Error: ' + str(err))

    def logging(self, type, msg):
        if not type is None:
            f = self.write_a(type, 'log')
            f.write(msg + '\n')
            f.close()

        print(msg)

    def read(self, name, type):
        return self.open_file(name, type, 'r')

    def write(self, name, type):
        return self.open_file(name, type, 'w')

    def write_a(self, name, type):
        return self.open_file(name, type, 'a')

    def open_file(self, name, type, param):
        fileDir = os.path.dirname(os.path.realpath('__file__'))
        filename = os.path.join(fileDir, 'files/' + name + '.' + type)

        return open(filename, param)