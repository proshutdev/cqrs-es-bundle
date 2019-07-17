pipeline {
  agent {
    node {
      label 'Docker'
    }

  }
  stages {
    stage('Build') {
      steps {
        echo 'build Step'
        mail(subject: 'test', body: 'test', from: 'jenkins', to: 'hamid.udc2gmail.com')
      }
    }
    stage('Test') {
      steps {
        timestamps()
      }
    }
  }
}