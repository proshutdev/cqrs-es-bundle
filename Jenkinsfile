pipeline {
  agent {
    node {
      label 'master'
    }

  }
  stages {
    stage('Build') {
      steps {
        echo 'build Step'
        mail(subject: 'test', body: 'test', from: 'jenkins', to: 'hamid.udc@gmail.com')
      }
    }
    stage('Test') {
      steps {
        timestamps()
      }
    }
  }
}